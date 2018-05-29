<?php

namespace ModelBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BorrarArchivosTemporalesCommand extends ContainerAwareCommand {

    protected function configure() {
        $this->setName('cron:borrarArchivosTemporales')
                ->setDescription('Comando para ejecutar todos los dias a media noche para borrar archivo de la carpeta temp');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $container = $this->getContainer();
        $rootDir = $container->get('kernel')->getRootDir();
        exec("rm -rf ".$rootDir.'/../web/uploads/temp/*');
    }

}
