<?php

namespace ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ModelBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesUsers extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

    public function getOrder() {
        return 9;
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
        $em = $this->container->get('doctrine')->getEntityManager();

        $entities = json_decode('[{"username":"admin","email":"admin@correo.com","enabled":"TRUE","password":"administrador123","roles":"ROLE_SONATA_ADMIN","documentId":123456},{"username":"Usuario 2","email":"correo2@gmail.com","enabled":"TRUE","password":"correo2@gmail.com*","roles":"ROLE_CLIENTE","documentId":123457},{"username":"Usuario 3","email":"correo3@gmail.com","enabled":"TRUE","password":"correo3@gmail.com*","roles":"ROLE_CLIENTE","documentId":123458},{"username":"Usuario 4","email":"correo4@gmail.com","enabled":"TRUE","password":"correo4@gmail.com*","roles":"ROLE_GESTOR","documentId":123459},{"username":"Usuario 5","email":"correo5@gmail.com","enabled":"TRUE","password":"correo5@gmail.com*","roles":"ROLE_GESTOR","documentId":123460},{"username":"Usuario 6","email":"correo6@gmail.com","enabled":"TRUE","password":"correo6@gmail.com*","roles":"ROLE_CLIENTE","documentId":123461},{"username":"Usuario 7","email":"correo7@gmail.com","enabled":"TRUE","password":"correo7@gmail.com*","roles":"ROLE_CLIENTE","documentId":123462},{"username":"Usuario 8","email":"correo8@gmail.com","enabled":"TRUE","password":"correo8@gmail.com*","roles":"ROLE_CLIENTE","documentId":123463},{"username":"Usuario 9","email":"correo9@gmail.com","enabled":"TRUE","password":"correo9@gmail.com*","roles":"ROLE_GESTOR","documentId":123464},{"username":"Usuario 10","email":"correo10@gmail.com","enabled":"TRUE","password":"correo10@gmail.com*","roles":"ROLE_CLIENTE","documentId":123465},{"username":"Usuario 11","email":"correo11@gmail.com","enabled":"TRUE","password":"correo11@gmail.com*","roles":"ROLE_GESTOR","documentId":123466},{"username":"Usuario 12","email":"correo12@gmail.com","enabled":"TRUE","password":"correo12@gmail.com*","roles":"ROLE_CLIENTE","documentId":123467},{"username":"Usuario 13","email":"correo13@gmail.com","enabled":"TRUE","password":"correo13@gmail.com*","roles":"ROLE_GESTOR","documentId":123468},{"username":"Usuario 14","email":"correo14@gmail.com","enabled":"TRUE","password":"correo14@gmail.com*","roles":"ROLE_GESTOR","documentId":123469},{"username":"Usuario 15","email":"correo15@gmail.com","enabled":"TRUE","password":"correo15@gmail.com*","roles":"ROLE_CLIENTE","documentId":123470},{"username":"Usuario 16","email":"correo16@gmail.com","enabled":"TRUE","password":"correo16@gmail.com*","roles":"ROLE_GESTOR","documentId":123471},{"username":"Usuario 17","email":"correo17@gmail.com","enabled":"TRUE","password":"correo17@gmail.com*","roles":"ROLE_GESTOR","documentId":123472},{"username":"Usuario 18","email":"correo18@gmail.com","enabled":"TRUE","password":"correo18@gmail.com*","roles":"ROLE_GESTOR","documentId":123473},{"username":"Usuario 19","email":"correo19@gmail.com","enabled":"TRUE","password":"correo19@gmail.com*","roles":"ROLE_CLIENTE","documentId":123474},{"username":"Usuario 20","email":"correo20@gmail.com","enabled":"TRUE","password":"correo20@gmail.com*","roles":"ROLE_GESTOR","documentId":123475},{"username":"Usuario 21","email":"correo21@gmail.com","enabled":"TRUE","password":"correo21@gmail.com*","roles":"ROLE_CLIENTE","documentId":123476},{"username":"Usuario 22","email":"correo22@gmail.com","enabled":"TRUE","password":"correo22@gmail.com*","roles":"ROLE_GESTOR","documentId":123477},{"username":"Usuario 23","email":"correo23@gmail.com","enabled":"TRUE","password":"correo23@gmail.com*","roles":"ROLE_CLIENTE","documentId":123478},{"username":"Usuario 24","email":"correo24@gmail.com","enabled":"TRUE","password":"correo24@gmail.com*","roles":"ROLE_GESTOR","documentId":123479},{"username":"Usuario 25","email":"correo25@gmail.com","enabled":"TRUE","password":"correo25@gmail.com*","roles":"ROLE_CLIENTE","documentId":123480},{"username":"Usuario 26","email":"correo26@gmail.com","enabled":"TRUE","password":"correo26@gmail.com*","roles":"ROLE_CLIENTE","documentId":123481},{"username":"Usuario 27","email":"correo27@gmail.com","enabled":"TRUE","password":"correo27@gmail.com*","roles":"ROLE_CLIENTE","documentId":123482},{"username":"Usuario 28","email":"correo28@gmail.com","enabled":"TRUE","password":"correo28@gmail.com*","roles":"ROLE_GESTOR","documentId":123483},{"username":"Usuario 29","email":"correo29@gmail.com","enabled":"TRUE","password":"correo29@gmail.com*","roles":"ROLE_GESTOR","documentId":123484},{"username":"Usuario 30","email":"correo30@gmail.com","enabled":"TRUE","password":"correo30@gmail.com*","roles":"ROLE_GESTOR","documentId":123485},{"username":"Usuario 31","email":"correo31@gmail.com","enabled":"TRUE","password":"correo31@gmail.com*","roles":"ROLE_GESTOR","documentId":123486},{"username":"Usuario 32","email":"correo32@gmail.com","enabled":"TRUE","password":"correo32@gmail.com*","roles":"ROLE_CLIENTE","documentId":123487},{"username":"Usuario 33","email":"correo33@gmail.com","enabled":"TRUE","password":"correo33@gmail.com*","roles":"ROLE_GESTOR","documentId":123488},{"username":"Usuario 34","email":"correo34@gmail.com","enabled":"TRUE","password":"correo34@gmail.com*","roles":"ROLE_CLIENTE","documentId":123489},{"username":"Usuario 35","email":"correo35@gmail.com","enabled":"TRUE","password":"correo35@gmail.com*","roles":"ROLE_GESTOR","documentId":123490},{"username":"Usuario 36","email":"correo36@gmail.com","enabled":"TRUE","password":"correo36@gmail.com*","roles":"ROLE_CLIENTE","documentId":123491},{"username":"Usuario 37","email":"correo37@gmail.com","enabled":"TRUE","password":"correo37@gmail.com*","roles":"ROLE_CLIENTE","documentId":123492},{"username":"Usuario 38","email":"correo38@gmail.com","enabled":"TRUE","password":"correo38@gmail.com*","roles":"ROLE_GESTOR","documentId":123493},{"username":"Usuario 39","email":"correo39@gmail.com","enabled":"TRUE","password":"correo39@gmail.com*","roles":"ROLE_CLIENTE","documentId":123494},{"username":"Usuario 40","email":"correo40@gmail.com","enabled":"TRUE","password":"correo40@gmail.com*","roles":"ROLE_GESTOR","documentId":123495},{"username":"Usuario 41","email":"correo41@gmail.com","enabled":"TRUE","password":"correo41@gmail.com*","roles":"ROLE_CLIENTE","documentId":123496},{"username":"Usuario 42","email":"correo42@gmail.com","enabled":"TRUE","password":"correo42@gmail.com*","roles":"ROLE_CLIENTE","documentId":123497},{"username":"Usuario 43","email":"correo43@gmail.com","enabled":"TRUE","password":"correo43@gmail.com*","roles":"ROLE_GESTOR","documentId":123498},{"username":"Usuario 44","email":"correo44@gmail.com","enabled":"TRUE","password":"correo44@gmail.com*","roles":"ROLE_CLIENTE","documentId":123499},{"username":"Usuario 45","email":"correo45@gmail.com","enabled":"TRUE","password":"correo45@gmail.com*","roles":"ROLE_GESTOR","documentId":123500},{"username":"Usuario 46","email":"correo46@gmail.com","enabled":"TRUE","password":"correo46@gmail.com*","roles":"ROLE_CLIENTE","documentId":123501},{"username":"Usuario 47","email":"correo47@gmail.com","enabled":"TRUE","password":"correo47@gmail.com*","roles":"ROLE_GESTOR","documentId":123502},{"username":"Usuario 48","email":"correo48@gmail.com","enabled":"TRUE","password":"correo48@gmail.com*","roles":"ROLE_GESTOR","documentId":123503},{"username":"Usuario 49","email":"correo49@gmail.com","enabled":"TRUE","password":"correo49@gmail.com*","roles":"ROLE_GESTOR","documentId":123504},{"username":"Usuario 50","email":"correo50@gmail.com","enabled":"TRUE","password":"correo50@gmail.com*","roles":"ROLE_GESTOR","documentId":123505}]');

        foreach ($entities as $key => $entity) {
            $object = new User();

            if ($key === 0) {
                $object->setUsername($entity->{'username'});
                $object->setUsernameCanonical($entity->{'username'});
            } else {
                $object->setUsername($entity->{'documentId'});
                $object->setUsernameCanonical($entity->{'documentId'});
            }

            $object->setEmail($entity->{'email'});
            $object->setEmailCanonical($entity->{'email'});
            $object->setEnabled($entity->{'enabled'});
            $encoder = $this->container
                    ->get('security.encoder_factory')
                    ->getEncoder($object)
            ;

            $clientes = $em->getRepository("ModelBundle:Cliente")->findAll();
            $cliente = $clientes[array_rand($clientes)];
            $setCliente = rand(0, 1);
            if ($setCliente == 1 && $entity->{'username'} != "admin") {
                $object->setCliente($cliente);
            }

            $object->setPassword($encoder->encodePassword($entity->{'password'}, $object->getSalt()));
            $object->setRoles(array($entity->{'roles'}));
            $object->setDocumentId($entity->{'documentId'});
            $object->setCredentialsExpired(false);
            $object->setLocked(false);
            $object->setExpired(false);
            if (!$object->getCliente() && $entity->{'roles'} == "ROLE_GESTOR") {
                $object->setEsKontrolGrun(true);
            } else {
                $object->setEsKontrolGrun(false);
            }
            $manager->persist($object);

            $this->addReference('user_' . $entity->{'username'}, $object);
        }
        $manager->flush();
    }

}
