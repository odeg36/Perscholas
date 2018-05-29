<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\FormaPago;

class FixturesFromaPago extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

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
                . '{"name":"Transacción Bancaria","meses":0},'
                . '{"name":"Pago de contado","meses":0},'
                . '{"name":"Pago a crédito mensual","meses":1},'
                . '{"name":"Pago a crédito trimestral","meses":3},'
                . '{"name":"Pago a crédito semestral","meses":6},'
                . '{"name":"Cuota mensual","meses":1},'
                . '{"name":"Cuota trimestral","meses":3},'
                . '{"name":"Cuota semestral","meses":6},'
                . '{"name":"Cuota anual","meses":12}'
                . ']');
        
        foreach ($entities as $entity) {
            $object = new FormaPago();
            
            $object->setNombre($entity->{'name'});
            $object->setPeriodoDePagoEnMeses($entity->{'meses'});
            $manager->persist($object);
        }
        $manager->flush();
    }
}