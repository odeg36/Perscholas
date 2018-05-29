<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ModelBundle\Entity\Cliente;
use ModelBundle\Entity\CentroRecoleccion;
use Doctrine\ORM\EntityRepository;

class FixturesCliente extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 2;
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
        $container = $this->container;
        $em = $container->get('doctrine')->getManager();

        $entities = json_decode('[{"direccion":"Calle 12 # 12 - 12","telefono":1234567,"nombre":"Exito","nit":"123456789-0","correo_electronico":"exito@exito.com","es_kontrol_grun":"0"}]');
        $medellin = $em->getRepository("ModelBundle:Municipio")->findOneByNombre(array('nombre' => "Envigado"));
        $zonas = $medellin->getZonas()->toArray();
        $estratos = $em->getRepository("ModelBundle:Estrato")->findAll();
        $formasPago = $em->getRepository("ModelBundle:FormaPago")->findAll();
        foreach ($entities as $entity) {
            $object = new Cliente();

            $tipos = $em->getRepository("ModelBundle:TipoCliente")->findAll();
            $object->setTipoCliente($tipos[array_rand($tipos)]);

            $object->setNombre($entity->{'nombre'});
            $object->setDireccion($entity->{'direccion'});
            $object->setIndicativo(rand(1, 10));
            $object->setNombreReplegal('Pedro Perez');
            $object->setCedulaReplegal(rand(1000000, 9999999));
            $object->setIndicativo(rand(1, 10));
            $object->setTelefono($entity->{'telefono'});
            $object->setCelular("320" . rand(000000, 999999));
            $object->setNit($entity->{'nit'});
            $object->setCorreoElectronico($entity->{'correo_electronico'});
            $object->setEstrato($estratos[array_rand($estratos)]);
            $object->setMunicipio($medellin);
            $object->setZona($zonas[array_rand($zonas)]);
            $object->setFechaInicioFacturacion(new \DateTime());
            $object->setFormaPago($formasPago[array_rand($formasPago)]);
            $object->setValorAPagar(rand(100000, 1000000));
            $manager->persist($object);

            $centro_costo = new CentroRecoleccion();
            $centro_costo->setActivo(true);
            $centro_costo->setCargoContacto("Gerente");
            $centro_costo->setCliente($object);
            $centro_costo->setDireccion("Calle 14 # 14 - 14");
            $centro_costo->setNombre("Centro 1 - " . $object->getNombre());
            $centro_costo->setNombreContacto("Pepito Perez");
            $centro_costo->setTelefono("3103333333");
            $centro_costo->setCelular("320" . rand(000000, 999999));
            $manager->persist($centro_costo);
        }
        $manager->flush();
    }

}
