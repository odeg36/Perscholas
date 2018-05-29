<?php

namespace BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;

class AddDepartamentoFieldSubscriber implements EventSubscriberInterface {

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

    private function addProvinceForm($form, $country_id, $province = null) {
        $formOptions = array(
            'class' => 'ModelBundle:Departamento',
            'empty_value' => 'Escoja un departamento',
            'label' => 'Departamento',
            'mapped' => false,
            'attr' => array(
                'class' => 'province_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($country_id) {
        $qb = $repository->createQueryBuilder('d')
                ->innerJoin('d.pais', 'p')
                ->where('p.id = :pais')
                ->setParameter('pais', $country_id)
        ;

        return $qb;
    }
        );

        if ($province) {
            $formOptions['data'] = $province;
        }

        $form->add('departamento', 'entity', $formOptions);
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
        $province = ($city) ? $city->getDepartamento() : null;
        $country_id = ($province) ? $province->getPais()->getId() : null;
        $this->addProvinceForm($form, $country_id, $province);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $country_id = array_key_exists('pais', $data) ? $data['pais'] : null;

        $this->addProvinceForm($form, $country_id);
    }

}
