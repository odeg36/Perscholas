<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller {

    public function precio_residuoAction(Request $request) {

        $request = $this->getRequest();
        $d_pr = $request->request->get("data");

        $em = $this->container->get("doctrine")->getManager();
        if (!$d_pr) {
            exit;
        }
        $precio_r = $em->getRepository("ModelBundle:Residuo")->findOneBy(array("id" => $d_pr));
        return new Response(json_encode(array("code" => 100, "success" => true, "precio" => $precio_r->getPrecioResiduo(), "tipo" => $precio_r->getId(), "color" => $precio_r->getColor())));
    }

    public function tipos_disposicionAction(Request $request) {
        $request = $this->getRequest();
        $d_pr = $request->request->get("data");

        $em = $this->container->get("doctrine")->getManager();
        $tipos_d = $em->getRepository("ModelBundle:Disposicion")->findBy(array("disposicion" => $d_pr));

        foreach ($tipos_d as $key => $value) {
            $disposicion [$key]["id"] = $value->getId();
            $disposicion [$key]["nombre"] = $value->getNombre();
            $disposicion [$key]["color"] = $value->getColor();
        }
        return new Response(json_encode(array("code" => 100, "success" => true, "disposicion" => $disposicion)));
    }

    public function calendario_recogidasAction(Request $request, $id) {
        $em = $this->container->get("doctrine")->getManager();
        $programaciones = $em->getRepository("ModelBundle:Programacion")->findBy(array("centro_recoleccion" => $id));
        $fechas = array();
        foreach ($programaciones as $programacion) {
            foreach ($programacion->getTiposResiduosTransporte() as $tipoResiduoTransporte) {
                $fechas_recolecciones = array();
                foreach ($tipoResiduoTransporte->getRecolecciones() as $recoleccion) {
                    $fecha = $recoleccion->getFechaProgramacion();
                    $fecha_unix = $fecha->format("U") * 1000;
                    $fecha_unix_final = (date('U', strtotime($fecha->format('Y-m-d') . ' +1 day')) * 1000) - 1;
                    $fechas_recolecciones ["id"] = $recoleccion->getId();
                    $fechas_recolecciones ["title"] = $programacion->getObservacion();
                    $fechas_recolecciones ["start"] = $fecha_unix;
                    $fechas_recolecciones ["end"] = $fecha_unix_final;
                }
                $color [] = $tipoResiduoTransporte->getTipoResiduo()->getColor();
                $fechas_recolecciones ["colores"] = $color;
                array_push($fechas, $fechas_recolecciones);
            }
        }

        return new Response(json_encode(array("success" => true, "result" => $fechas)));
    }

    public function centrosRecoleccionAction(Request $request) {
        $cliente_id = $request->request->get('cliente_id');
        $em = $this->getDoctrine()->getManager();
        $centros_recoleccion = $em->getRepository('ModelBundle:CentroRecoleccion')->findBy(array('cliente' => $cliente_id, 'activo' => true));
        $centros_recoleccion_array = array();
        foreach ($centros_recoleccion as $centro_recoleccion) {
            $centros_recoleccion_array[] = array(
                'id' => $centro_recoleccion->getId(),
                'name' => $centro_recoleccion->getNombre(),
            );
        }
        return new JsonResponse($centros_recoleccion_array);
    }

    public function userClienteAction(Request $request) {
        $cliente_id = $request->request->get('cliente_id');
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('ModelBundle:Cliente')->find($cliente_id);
        $usuariosKontrolGrun = $em->getRepository('ModelBundle:User')->findBy(array("es_kontrol_grun" => true));
        $gestores_array = array();
        if ($cliente) {
            $gestores = $cliente->getGestores();
            foreach ($usuariosKontrolGrun as $ukg) {
                $gestores_array[] = array(
                    'id' => $ukg->getId(),
                    'name' => $ukg->getUsername() . " - Kontrolgrun",
                );
            }
            foreach ($gestores as $gestor) {
                $gestores_array[] = array(
                    'id' => $gestor->getId(),
                    'name' => $gestor->getUsername() . " - " . $cliente->getNombre(),
                );
            }
        }
        return new JsonResponse($gestores_array);
    }

    public function residuosAction(Request $request) {
        $tipo_id = $request->request->get('tipo_residuo_id');
        $em = $this->getDoctrine()->getManager();
        $tipoResiduo = $em->getRepository('ModelBundle:TipoResiduo')->find($tipo_id);
        $residuos = $em->getRepository('ModelBundle:Residuo')->findBy(array('tipo_residuo' => $tipo_id));
        $residuos_array = array();
        $disposiciones_array = array();
        foreach ($residuos as $residuo) {
            $residuos_array[] = array(
                'id' => $residuo->getId(),
                'nombre' => $residuo->getNombre(),
                'densidad' => $residuo->getDensidad(),
            );
        }
        foreach ($tipoResiduo->getDisposicion()->getDisposiciones() as $disposicion) {
            $disposiciones_array[] = array(
                'id' => $disposicion->getId(),
                'nombre' => $disposicion->getNombre(),
            );
        }
        return new JsonResponse(array('residuos' => $residuos_array, 'disposicion' => array('nombre' => $tipoResiduo->getDisposicion(), 'disposiciones' => $disposiciones_array)));
    }

    public function listaMunicipiosAction(Request $request) {
        $id_dpto = $request->request->get("id");
        $em = $this->container->get("doctrine")->getManager();
        $municipios = $em->getRepository("ModelBundle:Municipio")->findBy(array("departamento" => $id_dpto));
        $municipios_array = array();
        foreach ($municipios as $municipio) {
            $municipios_array [] = array(
                "id" => $municipio->getId(),
                "nombre" => $municipio->getNombre()
            );
        }
        return new JsonResponse($municipios_array);
    }

    public function listaZonasAction(Request $request) {
        $id_municipio = $request->request->get("id");
        $em = $this->container->get("doctrine")->getManager();
        $zonas = $em->getRepository("ModelBundle:Zona")->findBy(array("municipio" => $id_municipio));
        $zonas_array = array();
        foreach ($zonas as $zona) {
            $zonas_array [] = array(
                "id" => $zona->getId(),
                "nombre" => $zona->getNombre()
            );
        }
        return new JsonResponse($zonas_array);
    }

    public function listaDepartamentosAction(Request $request) {
        $id_pais = $request->request->get("id");
        $em = $this->container->get("doctrine")->getManager();
        $departamentos = $em->getRepository("ModelBundle:Departamento")->findBy(array("pais" => $id_pais));
        $departamentos_array = array();
        foreach ($departamentos as $departamento) {
            $departamentos_array [] = array(
                "id" => $departamento->getId(),
                "nombre" => $departamento->getNombre()
            );
        }
        return new JsonResponse($departamentos_array);
    }

    public function tipoTransporteAction(Request $request) {
        $tipo = $request->request->get('tipo');
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        if ($tipo == "contenedor") {
            $tipos = $em->getRepository('ModelBundle:Contenedor')->findAll();
            if ($id) {
                $tipos = $em->getRepository('ModelBundle:Contenedor')->findById($id);
            }
        } else {
            $tipos = $em->getRepository('ModelBundle:Volqueta')->findAll();
            if ($id) {
                $tipos = $em->getRepository('ModelBundle:Volqueta')->findById($id);
            }
        }
        $tipos_array = array();
        foreach ($tipos as $tipo) {
            $tipos_array[] = array(
                'id' => $tipo->getId(),
                'name' => $tipo->getNombre(),
                'volumen' => $tipo->getVolumen(),
            );
        }
        return new JsonResponse($tipos_array);
    }

    public function alertasAction(Request $request) {
        $pagina = $request->get('pagina');
        $usuario = $this->getUser();
        $alertas_array = array();
        if ($usuario) {
            $em = $this->container->get("doctrine")->getManager();
            $dql = "SELECT a FROM ModelBundle:Alerta a WHERE a.usuario = " . $usuario->getId();
            $query = $em->createQuery($dql);
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                    $query, $pagina, 5
            );
            foreach ($pagination as $alerta) {
                $alertas_array [] = array(
                    "id" => $alerta->getId(),
                    "mensaje" => $alerta->getMensaje()
                );
            }
        }

        return new JsonResponse($alertas_array);
    }

}
