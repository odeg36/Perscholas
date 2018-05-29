<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BackendBundle\Form\EventListener\AddClienteFieldSubscriber;
use BackendBundle\Form\EventListener\AddCentroRecoleccionFieldSubscriber;

class SeguimientoPMIRSFormType extends AbstractType {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $container = $this->container;

        $choices = array('Sí' => 1, 'No' => 0);
        $builder
                ->add('cumple_seguimiento', 'choice', array('label' => '¿Cumple con el seguimiento?', 'choices' => $choices, 'expanded' => true, 'choices_as_values' => true, 'expanded' => true, 'multiple' => false, 'choice_value' => function ($currentChoiceKey) {
                        return $currentChoiceKey ? 1 : 0;
                    }, 'required' => true))
                ->add('fecha_ejecucion', 'sonata_type_date_picker', array('constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    ),
                    "label" => "Fecha de ejecución",
                    'dp_language' => 'es',
                    'format' => 'dd/MM/yyyy',
                    "required" => false,
                    'attr' => array(
                        'class' => 'form-control',
            )))
                ->add('atendio', null, array('label' => '¿Quién atendió?','constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    ),))
                ->add('elaboro', null, array('label' => '¿Quién elaboró?','constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    ),))
                ->add('conclusiones')
                ->add('archivo', 'file', array("data_class" => null, 'required' => false, 'label' => 'Archivo', 'mapped' => false))
        ;
        $propertyPath = 'centro_recoleccion';
        $builder
                ->addEventSubscriber(new AddClienteFieldSubscriber($propertyPath, $container))
                ->addEventSubscriber(new AddCentroRecoleccionFieldSubscriber($propertyPath, $container))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ModelBundle\Entity\SeguimientoPMIRS'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'seguimiento';
    }

}
