<?php

namespace BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;

class AddMunicipioFieldSubscriber implements EventSubscriberInterface {

    private $propertyPathToCity;
    private $container;

    public function __construct($propertyPathToCity, $container) {
        $this->propertyPathToCity = $propertyPathToCity;
        $this->container = $container;
    }

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addCityForm($form, $province_id,$city = null) {
        $formOptions = array(
            'class' => 'ModelBundle:Municipio',
            'empty_value' => 'Escoja un municipio',
            'label' => 'Municipio',
            'attr' => array(
                'class' => 'city_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($province_id) {
        $qb = $repository->createQueryBuilder('m')
                ->innerJoin('m.departamento', 'd')
                ->where('d.id = :departamento')
                ->setParameter('departamento', $province_id)
        ;

        return $qb;
    }
        );
        
        if ($city) {
            $formOptions['data'] = $city;
        }

        $form->add($this->propertyPathToCity, 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $city = $accessor->getValue($data, $this->propertyPathToCity);
        if (!$city) {
            $container = $this->container;
            $em = $container->get('doctrine')->getManager();
            $city = $em->getRepository('ModelBundle:Municipio')->findOneByNombre('Envigado');
        }
        $province_id = ($city) ? $city->getDepartamento()->getId() : null;

        $this->addCityForm($form, $province_id,$city);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $province_id = array_key_exists('departamento', $data) ? $data['departamento'] : null;

        $this->addCityForm($form, $province_id);
    }

}
