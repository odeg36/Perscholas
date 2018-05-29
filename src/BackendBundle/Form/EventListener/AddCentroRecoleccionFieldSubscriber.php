<?php

namespace BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\DependencyInjection\Container;

class AddCentroRecoleccionFieldSubscriber implements EventSubscriberInterface {

    private $propertyPath;
    public $container;

    public function __construct($propertyPath, Container $container) {
        $this->propertyPath = $propertyPath;
        $this->container = $container;
    }

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addCentroRecoleccionForm($form, $cliente_id) {
        $notBlank = array(
            new NotBlank(array(
                'message' => 'El campo no puede estar vacío.',
                    ))
        );
        $formOptions = array(
            'label' => "Centro de costo",
            'class' => 'ModelBundle:CentroRecoleccion',
            'empty_value' => 'Escoja un centro de costo',
            'attr' => array(
                'class' => 'centro_recoleccion_selector',
            ),
            'constraints' => $notBlank,
            'query_builder' => function (EntityRepository $repository) use ($cliente_id) {
        $qb = $repository->createQueryBuilder('cc')
                ->innerJoin('cc.cliente', 'c')
                ->where('c.id = :cliente')
                ->setParameter('cliente', $cliente_id)
        ;

        return $qb;
    }
        );

        $form->add($this->propertyPath, 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $centro_recoleccion = $accessor->getValue($data, $this->propertyPath);
        $cliente_id = ($centro_recoleccion) ? $centro_recoleccion->getCliente()->getId() : null;
        if (!$cliente_id) {
            $container = $this->container;
            $user = $container->get('security.context')->getToken() ? $container->get('security.context')->getToken()->getUser() : null;
            if ($user && $user->getCliente()) {
                $cliente_id = $user->getCliente()->getId();
            }
        }
        $this->addCentroRecoleccionForm($form, $cliente_id);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $cliente_id = array_key_exists('cliente', $data) ? $data['cliente'] : null;

        $this->addCentroRecoleccionForm($form, $cliente_id);
    }

}
