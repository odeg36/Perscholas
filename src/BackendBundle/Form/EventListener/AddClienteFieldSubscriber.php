<?php

namespace BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityRepository;

class AddClienteFieldSubscriber implements EventSubscriberInterface {

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

    private function addClienteForm($form, $cliente = null) {
        $notBlank = array(
            new NotBlank(array(
                'message' => 'El campo no puede estar vacío.',
                    ))
        );
        $formOptions = array(
            'class' => 'ModelBundle:Cliente',
            'mapped' => false,
            'empty_value' => 'Escoja un cliente',
            'attr' => array(
                'class' => 'cliente_selector',
            ),
            'constraints' => $notBlank
        );
        $container = $this->container;
        $user = $container->get('security.context')->getToken() ? $container->get('security.context')->getToken()->getUser() : null;

        if ($user && $user->hasRole('ROLE_GESTOR')) {
            $formOptions['query_builder'] = function (EntityRepository $repository) use ($cliente) {
                $qb = $repository->createQueryBuilder('c')
                        ->where('c.id = :cliente')
                        ->setParameter('cliente', $cliente->getId())
                ;

                return $qb;
            };
            $formOptions['attr'] = array(
                'disabled' => true
            );
        }
        if ($cliente) {
            $formOptions['data'] = $cliente;
        }

        $form->add('cliente', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $centro_recoleccion = $accessor->getValue($data, $this->propertyPath);
        $cliente = ($centro_recoleccion) ? $centro_recoleccion->getCliente() : null;
        $user = null;
        if (!$cliente) {
            $container = $this->container;
            $user = $container->get('security.context')->getToken() ? $container->get('security.context')->getToken()->getUser() : null;
            if ($user && $user->getCliente()) {
                $cliente = $user->getCliente();
            }
        }
        $this->addClienteForm($form, $cliente);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $cliente = null;
        if (!$cliente) {
            $container = $this->container;
            $user = $container->get('security.context')->getToken() ? $container->get('security.context')->getToken()->getUser() : null;
            if ($user && $user->getCliente()) {
                $cliente = $user->getCliente();
            }
        }
        $this->addClienteForm($form,$cliente);
    }

}
