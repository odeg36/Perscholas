<?php

namespace ModelBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerarFacturasCommand extends ContainerAwareCommand {

    protected function configure() {
        $this->setName('cron:generarFacturas')
                ->setDescription('Comando para consultar todos los clientes y generar sus facturas');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $clientes = $em->getRepository('ModelBundle:Cliente')->findBy(array('exentopago' => "0" ));
        foreach ($clientes as $cliente) {
            $container->get('app.generar_factura')->pdf($cliente);
        }
        $em->flush();
    }

}
