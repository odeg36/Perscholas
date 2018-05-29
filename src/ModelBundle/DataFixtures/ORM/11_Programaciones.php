<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\Programacion;
use ModelBundle\Entity\TipoResiduoTransporte;
use ModelBundle\Entity\Recoleccion;
use ModelBundle\Entity\RecoleccionVolqueta;
use ModelBundle\Entity\RecoleccionContenedor;
use ModelBundle\Entity\ResiduoRecoleccion;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesProgramaciones extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 11;
    }

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
//        $container = $this->container;
//        $em = $container->get('doctrine')->getManager();
//
//        $centros = $em->getRepository("ModelBundle:CentroRecoleccion")->findAll();
//        $tiposResiduos = $em->getRepository("ModelBundle:TipoResiduo")->findAll();
//        $contenedores = $em->getRepository("ModelBundle:Contenedor")->findAll();
//        $volquetas = $em->getRepository("ModelBundle:Volqueta")->findAll();
//        $empresasRecolectoras = $em->getRepository("ModelBundle:EmpresaRecolectoraResiduos")->findAll();
//        $tipoResiduo = new \ModelBundle\Entity\TipoResiduo();
//        $fechaActual = date('Y') . "-01-01";
//        $fecha = null;
//        for ($i = 0; $i < date('m'); $i++) {
//            $programacion = new Programacion();
//            $centroRecoleccion = $centros[array_rand($centros)];
//            $programacion->setCentroRecoleccion($centroRecoleccion);
//            $gestores = $centroRecoleccion->getCliente()->getGestores();
//            $programacion->setGestorAmbiental($gestores[array_rand($gestores)]);
//            $programacion->setPesadoEnCentroRecoleccion(rand(0, 1));
//            $programacion->setObservacion('programacion ' . $i);
//            foreach ($tiposResiduos as $tipoResiduo) {
//                $residuos = $tipoResiduo->getResiduos();
//                $disposiciones = $tipoResiduo->getDisposicion()->getDisposiciones()->toArray();
//                $tipoResiduoTransporte = new TipoResiduoTransporte();
//                $tipoResiduoTransporte->setProgramacion($programacion);
//                $tipoResiduoTransporte->setTipoResiduo($tipoResiduo);
//                $tipoResiduoTransporte->setValidado(1);
//                $manager->persist($tipoResiduoTransporte);
//                for ($j = 0; $j < 3; $j++) {
//                    $recoleccion = new Recoleccion();
//                    if (!$fecha) {
//                        $fecha = $fechaActual;
//                    }
//                    $recoleccion->setFechaProgramacion(new \DateTime($fecha));
//                    $recoleccion->setFechaRecoleccionEjecutada(new \DateTime($fecha));
//                    $recoleccion->setTipoResiduoTransporte($tipoResiduoTransporte);
//                    $manager->persist($recoleccion);
//                    $recoleccionTransporte = null;
//                    if ($tipoResiduo->getUsaContenedor() || $tipoResiduo->getUsaVolqueta()) {
//                        $randTransporte = rand(0, 1);
//                        if ($randTransporte == 0) {
//                            $recoleccionTransporte = new RecoleccionContenedor();
//                            $recoleccionTransporte->setCantidad(rand(1, 10));
//                            $contenedor = $contenedores[array_rand($contenedores)];
//                            $recoleccionTransporte->setContenedor($contenedor);
//                            $recoleccionTransporte->setVolumen($contenedor->getVolumen());
//                            $recoleccionTransporte->setRecoleccion($recoleccion);
//                        } else {
//                            $recoleccionTransporte = new RecoleccionVolqueta();
//                            $recoleccionTransporte->setCantidad(rand(1, 2));
//                            $volqueta = $volquetas[array_rand($volquetas)];
//                            $recoleccionTransporte->setVolqueta($volqueta);
//                            $recoleccionTransporte->setVolumen($volqueta->getVolumen());
//                            $recoleccionTransporte->setRecoleccion($recoleccion);
//                        }
//                        $manager->persist($recoleccionTransporte);
//                    }
//                    foreach ($residuos as $residuo) {
//                        $residuoRecoleccion = new ResiduoRecoleccion();
//                        if ($recoleccionTransporte) {
//                            $residuoRecoleccion->setDensidad(mt_rand(0 * 10, 3 * 10) / 10);
//                            $peso = $recoleccionTransporte->getVolumen() * $recoleccionTransporte->getCantidad() * $residuoRecoleccion->getDensidad();
//                            $residuoRecoleccion->setPeso($peso);
//                            $residuoRecoleccion->setPrecio(mt_rand(1 * 10, 100 * 10) / 10);
//                        } else {
//                            $residuoRecoleccion->setPeso(mt_rand(1 * 10, 3 * 10) / 10);
//                            if ($tipoResiduo->getNombre() == 'Peligrosos') {
//                                $residuoRecoleccion->setPrecio((float) "-" . mt_rand(1 * 10, 3 * 10) / 10);
//                            } else {
//                                $residuoRecoleccion->setPrecio(mt_rand(1 * 10, 100 * 10) / 10);
//                            }
//                        }
//                        $residuoRecoleccion->setDisposicion($disposiciones[array_rand($disposiciones)]);
//                        $residuoRecoleccion->setEmpresaRecolectoraResiduos($empresasRecolectoras[array_rand($empresasRecolectoras)]);
//                        $reciclable = rand(0, 1);
//                        $residuoRecoleccion->setReciclabe($reciclable);
//                        $residuoRecoleccion->setRecoleccion($recoleccion);
//                        $residuoRecoleccion->setResiduo($residuo);
//                        $manager->persist($residuoRecoleccion);
//                    }
//                }
//            }
//            $programacion->setFechaCreacion(new \DateTime($fechaActual));
//            $fecha = date('Y-m-d H:i:s', strtotime($fechaActual . ' +1 month'));
//            $fechaActual = $fecha;
//            $manager->persist($programacion);
//        }
//        $manager->flush();
    }

}
