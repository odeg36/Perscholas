<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\Pais;
use ModelBundle\Entity\Departamento;
use ModelBundle\Entity\Municipio;
use ModelBundle\Entity\Zona;

class FixturesPaisDepartamentosMunicipiosZonas extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 0;
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
        $string = file_get_contents(__DIR__ . "/../../Resources/public/departamentosMunicipios.json");
        $json_departamentos = json_decode($string, true);
        foreach ($json_departamentos as $pais) {
            $pais_object = new Pais();
            $pais_object->setNombre($pais['pais']);
            foreach ($pais['departamentos'] as $departamento) {
                $departamento_object = new Departamento();
                $departamento_object->setNombre($departamento['departamento']);
                $departamento_object->setPais($pais_object);
                foreach ($departamento['ciudades'] as $municipio) {
                    $municipio_object = new Municipio();
                    $municipio_object->setDepartamento($departamento_object);
                    $municipio_object->setNombre($municipio);
                    $manager->persist($municipio_object);
                    if ($municipio == "Envigado") {
                        for ($index = 1; $index <= 13; $index++) {
                            $newZona = new Zona();
                            $newZona->setMunicipio($municipio_object);
                            $newZona->setNombre("Zona " . $index);
                            $manager->persist($newZona);
                        }
                    }
                    if ($municipio == "Medellín") {
                        $newZona = new Zona();
                        $newZona->setMunicipio($municipio_object);
                        $newZona->setNombre("Zona nororiental");
                        $manager->persist($newZona);
                        
                        $newZona = new Zona();
                        $newZona->setMunicipio($municipio_object);
                        $newZona->setNombre("Zona noroccidental");
                        $manager->persist($newZona);
                        
                        $newZona = new Zona();
                        $newZona->setMunicipio($municipio_object);
                        $newZona->setNombre("Zona centro-oriental");
                        $manager->persist($newZona);
                        
                        $newZona = new Zona();
                        $newZona->setMunicipio($municipio_object);
                        $newZona->setNombre("Zona centro-occidental");
                        $manager->persist($newZona);
                        
                        $newZona = new Zona();
                        $newZona->setMunicipio($municipio_object);
                        $newZona->setNombre("Zona suroriental");
                        $manager->persist($newZona);
                        
                        $newZona = new Zona();
                        $newZona->setMunicipio($municipio_object);
                        $newZona->setNombre("Zona suroccidental");
                    }
                }
                $manager->persist($departamento_object);
            }
            $manager->persist($pais_object);
        }
        $manager->flush();
    }

}
