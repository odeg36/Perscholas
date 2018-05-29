<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\TipoCliente;

class FixturesTipoCliente extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 1;
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
        $entities = json_decode('['
                . '{"name":"Constructora"},'
                . '{"name":"Oficina"},'
                . '{"name":"Hospital/Clínica"},'
                . '{"name":"Centro comercial"},'
                . '{"name":"Urbanización o similares"},'
                . '{"name":"Empresa"},'
                . '{"name":"Institución educativa"}'
                . ']');
        
        foreach ($entities as $entity) {
            $object = new TipoCliente();
            
            $object->setNombre($entity->{'name'});
            $manager->persist($object);
        }
        $manager->flush();
    }
}