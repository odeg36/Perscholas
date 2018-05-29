<?php

namespace ModelBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

class Volquetas extends \Twig_Extension {

    protected $container;

    public function __construct(Container $container = null) {
        $this->container = $container;
    }

    public function getFunctions() {
        return array('getVolquetas' => new \Twig_Function_Method($this, 'volquetas'),);
    }

    public function volquetas() {
        $em = $this->container->get('doctrine');
        $volquetas = $em->getRepository('ModelBundle:Volqueta')->findAll();
        return $volquetas;
    }


    public function getName() {
        return 'get_volquetas';
    }

}
