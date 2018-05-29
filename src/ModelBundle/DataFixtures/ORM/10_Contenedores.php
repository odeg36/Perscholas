<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\Contenedor;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesContenedores extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

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
                    {"nombre":"1 Litro","volumen":0.001},
                    {"nombre":"2 Litros","volumen":0.002},
                    {"nombre":"5 Litros","volumen":0.005},
                    {"nombre":"10 Litros","volumen":0.01},
                    {"nombre":"20 Litros","volumen":0.02},
                    {"nombre":"53 Litros","volumen":0.053},
                    {"nombre":"55 Litros","volumen":0.055},
                    {"nombre":"122 Litros","volumen":0.122},
                    {"nombre":"180 Litros","volumen":0.18},
                    {"nombre":"260 Litros","volumen":0.26},
                    {"nombre":"360 Litros","volumen":0.36},
                    {"nombre":"1600 Litros","volumen":1.6},
                    {"nombre":"2290 Litros","volumen":2.29}
                    ]');
        
        foreach ($entities as $entity) {
            $object = new Contenedor();
            
            $object->setNombre($entity->{'nombre'});
            $object->setVolumen($entity->{'volumen'});
            $manager->persist($object);
        }
        $manager->flush();
    }
}