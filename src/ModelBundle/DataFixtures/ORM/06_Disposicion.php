<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\Disposicion;

class FixturesDisposicion extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 6;
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
   {
      "name":"Ordinario",
      "id":1
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Ordinario",
      "id":1
   },
   {
      "name":"Tratamiento mecánico Biológico TMB",
      "disposicion":"Ordinario",
      "id":1
   },
   {
      "name":"Incineración sin recuperación de la energía",
      "disposicion":"Ordinario",
      "id":1
   },
   {
      "name":"Incineración con recuperación de la energía",
      "disposicion":"Ordinario",
      "id":1
   },
   {
      "name":"Reciclable",
      "id":2
   },
   {
      "name":"Plantas de reciclado",
      "disposicion":"Reciclable",
      "id":2
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Reciclable",
      "id":2
   },
   {
      "name":"Orgánico",
      "id":3
   },
   {
      "name":"Compostaje",
      "disposicion":"Orgánico",
      "id":3
   },
   {
      "name":"Tratamiento mecánico Biológico TMB",
      "disposicion":"Orgánico",
      "id":3
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Orgánico",
      "id":3
   },
   {
      "name":"Peligroso",
      "id":4
   },
   {
      "name":"Incineración sin recuperación de la energía",
      "disposicion":"Peligroso",
      "id":4
   },
   {
      "name":"Celda de seguridad",
      "disposicion":"Peligroso",
      "id":4
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Peligroso",
      "id":4
   },
   {
      "name":"Electronico",
      "id":5
   },
   {
      "name":"Plantas de reciclado",
      "disposicion":"Electronico",
      "id":5
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Electronico",
      "id":5
   },
   {
      "name":"RCD",
      "id":6
   },
   {
      "name":"Escombrera",
      "disposicion":"RCD",
      "id":6
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"RCD",
      "id":6
   },
   {
      "name":"Especiales",
      "id":7
   },
   {
      "name":"Plantas de reciclado",
      "disposicion":"Especiales",
      "id":7
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Especiales",
      "id":7
   },
   {
      "name":"Hospitalarios",
      "id":8
   },
   {
      "name":"Incineracion sin recuperación de la energía",
      "disposicion":"Hospitalarios",
      "id":8
   },
   {
      "name":"Celda de seguridad",
      "disposicion":"Hospitalarios",
      "id":8
   },
   {
      "name":"Relleno sanitario",
      "disposicion":"Hospitalarios",
      "id":8
   }
]');

        foreach ($entities as $entity) {
            $object = new Disposicion();

            $object->setNombre($entity->{'name'});

            if (isset($entity->{'disposicion'})) {
                $object->setDisposicion($this->getReference('disposicion_' . $entity->{'disposicion'} . "_" . $entity->{'id'}));
            }

            $this->addReference('disposicion_' . $entity->{'name'} . "_" . $entity->{'id'}, $object);
            $manager->persist($object);
        }
        $manager->flush();
    }

}
