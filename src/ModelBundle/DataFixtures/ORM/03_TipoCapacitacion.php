<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\TipoCapacitacion;

class FixturesTipoCapacitacion extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 3;
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
        $entities = json_decode('[{"name":"Virtual"},{"name":"Puerta a puerta"},{"name":"General"}]');
        
        foreach ($entities as $entity) {
            $object = new TipoCapacitacion();
            
            $object->setNombre($entity->{'name'});
            $manager->persist($object);
        }
        $manager->flush();
    }
}