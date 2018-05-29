<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
//        if ($this->container->get('security.context')->isGranted('ROLE_SONATA_ADMIN') || $this->container->get('security.context')->isGranted('ROLE_GESTOR')) {
//            return $this->redirect($this->generateUrl("sonata_admin_dashboard"));
//        }
        return $this->render('FrontendBundle:Main:index.html.twig', array('ruta' => 'homepage'));
    }

    public function passwordRecoveryAction() {
        $user = $this->getUser();
        $is_super_admin = false;
        foreach ($user->getRoles() as $rol) {
            if ($rol == 'ROLE_SONATA_ADMIN') {
                $is_super_admin = true;
            }
        }
        if ($is_super_admin) {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        } else {
            return $this->redirect($this->generateUrl('frontend_homepage'));
        }
    }

    public function calendarioAction() {
        $em = $this->getDoctrine()->getManager();
        $clientes = null;
        $centros = null;
        $user = $this->getUser();
        if ($user->hasRole('ROLE_SONATA_ADMIN')) {
            $clientes = $em->getRepository('ModelBundle:Cliente')->findAll();
        } else {
            $centros = $user->getCliente()->getCentrosRecoleccion();
        }
        return $this->render('FrontendBundle:Calendario:calendario.html.twig', array('centros' => $centros, 'clientes' => $clientes, 'ruta' => 'calendario'));
    }

    public function informesAction() {
        $usuario = $this->container->get('security.context')->getToken()->getUser();
        $rol = $usuario->getRoles();
        $id = $usuario->getId();

        $em = $this->getDoctrine()->getManager();


        if ($rol[0] == "ROLE_SONATA_ADMIN") {
            $informes = $em->getRepository('ModelBundle:CentroRecoleccion')->findAll();
        } else {
            $informes = $em->getRepository('ModelBundle:CentroRecoleccion')
                    ->createQueryBuilder('s')
//                ->where('u.id = ?1')
//                ->setParameter(1, $id)
                    ->getQuery()
                    ->getResult();
        }

        return $this->render('FrontendBundle:Informes:informes.html.twig', array('informes' => $informes, 'ruta' => 'informes'));
    }

    public function facturacionAction() {
        $usuario = $this->getUser();
        $facturas = array();
        if ($usuario->getCliente()) {
            $facturas = $usuario->getCliente()->getFacturas();
        }
        return $this->render('FrontendBundle:Facturacion:facturacion.html.twig', array('facturas' => $facturas, 'ruta' => 'facturacion'));
    }

    public function soportesAction() {
        $usuario = $this->getUser();
        $soportes = array();
        if ($usuario && $usuario->getCliente()) {
            $soportes = $usuario->getCliente()->getSoportes();
        }
        return $this->render('FrontendBundle:Soporte:soporte.html.twig', array('soportes' => $soportes, 'ruta' => 'soportes'));
    }

    public function helpAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tipo = $request->get('tipo');
        if ($tipo == "manuales") {
            $qb = $em->getRepository('ModelBundle:ManualUsuario')->createQueryBuilder('m');
            if ($this->getUser()->hasRole('ROLE_GESTOR')) {
                $qb->where("m.roles like '%ROLE_GESTOR%'");
            } elseif ($this->getUser()->hasRole('ROLE_CLIENTE')) {
                $qb->where("m.roles like '%ROLE_CLIENTE%'");
            }
            $query = $qb->getQuery();
            $objectos = $query->getResult();
        } else {
            $qb = $em->getRepository('ModelBundle:PreguntaFrecuentre')->createQueryBuilder('m');
            if ($this->getUser()->hasRole('ROLE_GESTOR')) {
                $qb->where("m.roles like '%ROLE_GESTOR%'");
            } elseif ($this->getUser()->hasRole('ROLE_CLIENTE')) {
                $qb->where("m.roles like '%ROLE_CLIENTE%'");
            }
            $query = $qb->getQuery();
            $objectos = $query->getResult();
        }
        return $this->render('FrontendBundle:Help:help.html.twig', array(
                    'ruta' => 'ayuda',
                    'objetos' => $objectos,
                    'tipo' => $tipo
        ));
    }

}
