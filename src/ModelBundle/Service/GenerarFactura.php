<?php

namespace ModelBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use ModelBundle\Entity\Cliente;

class GenerarFactura extends \Twig_Extension {

    protected $container;

    public function __construct(Container $container = null) {
        $this->container = $container;
    }

    public function pdf(Cliente $cliente) {
        $container = $this->container;

        $fechaInicio = $cliente->getFechaInicioFacturacion();
        if ($fechaInicio) {
            $formaPago = $cliente->getFormaPago();
            $periodo = $formaPago->getPeriodoDePagoEnMeses();
            $now = new \DateTime();
            $interval = $now->diff($fechaInicio);
            $meses = $interval->format('%m');
            $nombreFactura = $cliente->getNombre() . "_" . date('Y_m_d') . "__" . rand(0, 10000) . ".pdf";
            if ($periodo != 0) {
                if ($meses % $periodo == 0) {
                    try {
                        echo "Factura de " . $cliente->getNombre() . "\n\n";
                        $em = $container->get('doctrine')->getManager();
                        $newFactura = new \ModelBundle\Entity\Facturacion();
                        $newFactura->setCliente($cliente);
                        $newFactura->setValorAPagar($cliente->getValorAPagar());
                        $container->get('knp_snappy.pdf')->generateFromHtml(
                                $this->renderView(
                                        'ModelBundle:Cliente:factura.html.twig', array(
                                    'cliente' => $cliente,
                                    'factura' => $newFactura,
                                    'base_dir' => $container->get('kernel')->getRootDir() . '/../web/',
                                        )
                                ), $container->get('kernel')->getRootDir() . '/../web/uploads/facturas/' . $nombreFactura
                        );
                        $newFactura->setFactura($nombreFactura);
                        $em->persist($newFactura);
                        $mensaje = "Grünberta generó su factura correspondiente a la fecha " . $now->format('Y-m-d');
                        $usuarios = $cliente->getUsuarios();
                        foreach ($usuarios as $usuario) {
                            $newAlerta = new \ModelBundle\Entity\Alerta();
                            $newAlerta->setMensaje($mensaje);
                            $newAlerta->setUsuario($usuario);
                            $em->persist($newAlerta);
                        }
                        $em->flush();
                    } catch (\Exception $e) {
                        echo ($e->getMessage() . "\n\n");
                    }
                }
            }
        }
    }

    public function renderView($view, array $parameters = array()) {
        if ($this->container->has('templating')) {
            return $this->container->get('templating')->render($view, $parameters);
        }

        if (!$this->container->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available.');
        }

        return $this->container->get('twig')->render($view, $parameters);
    }

    public function getName() {
        return 'generar_factura';
    }

}
