<?php

namespace ModelBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VerificarDisposicionCommand extends ContainerAwareCommand {

    protected function configure() {
        $this->setName('cron:verificarDisposicion')
                ->setDescription('Commando a ejecutar cada dia para verificar si han pasado 15 o 30 días desde la creacion del manifiesto de transporte y de este verificar si existe el archivo de disposicion');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $tiposResiduo = $em->getRepository('ModelBundle:TipoResiduoTransporte')->findBy(array('certificado_disposicion' => null));
        $tipoResiduoTransporte = new \ModelBundle\Entity\TipoResiduoTransporte();
        foreach ($tiposResiduo as $tipoResiduoTransporte) {
            $today = new \DateTime();
            if ($tipoResiduoTransporte->getUltimaFechaRecoleccion()) {
                $dDiff = $today->diff($tipoResiduoTransporte->getUltimaFechaRecoleccion());
            } else {
                $dDiff = $today->diff($tipoResiduoTransporte->getFechaCreacion());
            }
            if ($dDiff->days % 15 == 0 && $tipoResiduoTransporte->getTipoResiduo()->getValidarDisposicion()) {
                $mensaje = 'De la recoleccion con fecha ' . $tipoResiduoTransporte->getUltimaFechaRecoleccion()->format('Y-m-d') . " no se há subido el certificado de disposición";
                $gestor = $tipoResiduoTransporte->getProgramacion()->getGestorAmbiental();
                $newAlerta = new \ModelBundle\Entity\Alerta();
                $newAlerta->setMensaje($mensaje);
                $newAlerta->setUsuario($gestor);
                $em->persist($newAlerta);
            } else {
                if ($dDiff->days >= 30) {
                    $tipoResiduoTransporte->setValidado(true);
                    $em->persist($tipoResiduoTransporte);
                }
            }
        }
        $em->flush();
    }

}
