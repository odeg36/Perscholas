<?php

namespace BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AddPaisFieldSubscriber implements EventSubscriberInterface {

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

    private function addCountryForm($form, $country = null) {
        $formOptions = array(
            'class' => 'ModelBundle:Pais',
            'mapped' => false,
            'label' => 'País',
            'empty_value' => 'Escoja un País',
            'attr' => array(
                'class' => 'country_selector',
            ),
        );

        if ($country) {
            $formOptions['data'] = $country;
        }

        $form->add('pais', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $city = $accessor->getValue($data, $this->propertyPathToCity);
        if (!$city) {
            $container = $this->container;
            $em = $container->get('doctrine')->getManager();
            $city = $em->getRepository('ModelBundle:Municipio')->findOneByNombre('Medellín');
        }
        $country = ($city) ? $city->getDepartamento()->getPais() : null;

        $this->addCountryForm($form, $country);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();

        $this->addCountryForm($form);
    }

}
