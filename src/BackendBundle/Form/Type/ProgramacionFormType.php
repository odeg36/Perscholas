<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BackendBundle\Form\EventListener\AddClienteFieldSubscriber;
use BackendBundle\Form\EventListener\AddCentroRecoleccionFieldSubscriber;
use Symfony\Component\DependencyInjection\Container;

class ProgramacionFormType extends AbstractType {

    public $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $container = $this->container;
        $user = $container->get('security.context')->getToken()->getUser();
        $cliente = null;
        if ($user && $user->getCliente()) {
            $cliente = $user->getCliente();
        }
        $builder
                ->add('pesado_en_centro_recoleccion', 'choice', array(
                    'label' => '¿Pesado en centro de costo?',
                    'choices' => array(
                        'Sí' => true,
                        'No' => false
                    ),
                    'choices_as_values' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'choice_value' => function ($currentChoiceKey) {
                return $currentChoiceKey ? 'true' : 'false';
            },
                ))
        ;

        $propertyPath = 'centro_recoleccion';
        $builder
                ->addEventSubscriber(new AddClienteFieldSubscriber($propertyPath,$container))
                ->addEventSubscriber(new AddCentroRecoleccionFieldSubscriber($propertyPath,$container));
        $builder
                ->add('gestor_ambiental', 'hidden', array(
                    'mapped' => false
                ))
                ->add("observacion", null, array('label' => 'Observación'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ModelBundle\Entity\Programacion'
        ));
    }

}
