<?php

namespace BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;

class AddZonaFieldSubscriber implements EventSubscriberInterface {

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

    private function addCityForm($form, $municipio_id) {
        $formOptions = array(
            'required' => false,
            'class' => 'ModelBundle:Zona',
            'empty_value' => 'Escoja una zona',
            'label' => 'Zona',
            'attr' => array(
                'class' => 'city_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($municipio_id) {
        $qb = $repository->createQueryBuilder('z')
                ->innerJoin('z.municipio', 'm')
                ->where('m.id = :municipio')
                ->setParameter('municipio', $municipio_id)
        ;
        return $qb;
    }
        );
        $form->add('zona', 'entity', $formOptions);
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
        $province_id = ($city) ? $city->getId() : null;

        $this->addCityForm($form, $province_id);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $province_id = array_key_exists('municipio', $data) ? $data['municipio'] : null;

        $this->addCityForm($form, $province_id);
    }

}
