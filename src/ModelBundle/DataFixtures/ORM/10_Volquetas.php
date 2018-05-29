<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\Volqueta;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesVolquetas extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 10;
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
        $entities = json_decode('[
                                {"nombre":"5000 Litros","volumen":5},
                                {"nombre":"7000 Litros","volumen":7},
                                {"nombre":"9000 Litros","volumen":9},
                                {"nombre":"12000 Litros","volumen":12},
                                {"nombre":"14000 Litros","volumen":14},
                                {"nombre":"18000 Litros","volumen":18},
                                {"nombre":"20000 Litros","volumen":20},
                                {"nombre":"32000 Litros","volumen":32},
                                {"nombre":"36000 Litros","volumen":36},
                                {"nombre":"40000 Litros","volumen":40},
                                {"nombre":"60000 Litros","volumen":60},
                                {"nombre":"65000 Litros","volumen":65}
                                ]');
        
        foreach ($entities as $entity) {
            $object = new Volqueta();
            
            $object->setNombre($entity->{'nombre'});
            $object->setVolumen($entity->{'volumen'});
            $manager->persist($object);
        }
        $manager->flush();
    }
}