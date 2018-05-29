<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\TipoSoporte;

class FixturesTipoSoporte extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 5;
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
                . '{"name":"Autorización del Gestor(Autoridad Ambiental)"},'
                . '{"name":"Certificado de Aprobación del PMIRS"},'
                . '{"name":"Factura de empresa publica de Aseo"},'
                . '{"name":"Facturas"},'
                . '{"name":"Planilla de residuos No-Reciclables"},'
                . '{"name":"Sanciones"},'
                . '{"name":"Otros"}'
                . ']');
        
        foreach ($entities as $entity) {
            $object = new TipoSoporte();
            
            $object->setNombre($entity->{'name'});
            $manager->persist($object);
        }
        $manager->flush();
    }
}