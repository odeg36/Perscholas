<?php

namespace ModelBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

class Contenedores extends \Twig_Extension {

    protected $container;

    public function __construct(Container $container = null) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array('getContenedores' => new \Twig_Function_Method($this, 'contenedores'),);
    }

    public function contenedores() {
        $em = $this->container->get('doctrine');
        $contenedores = $em->getRepository('ModelBundle:Contenedor')->findAll();
        return $contenedores;
    }


    public function getName() {
        return 'get_contenedores';
    }

}
