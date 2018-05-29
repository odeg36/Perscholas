<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BackendBundle\Form\EventListener\AddPaisFieldSubscriber;
use BackendBundle\Form\EventListener\AddDepartamentoFieldSubscriber;
use BackendBundle\Form\EventListener\AddMunicipioFieldSubscriber;
use BackendBundle\Form\EventListener\AddZonaFieldSubscriber;

class ClienteFormType extends AbstractType {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $object = $builder->getData();
        $container = $this->container;
        $builder
                ->add('nombre')
                ->add('direccion', 'text', array(
                    'label' => 'Dirección',
                    'attr' => array('readonly' => true),
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )
                ))
                ->add('direccion_format', new \ModelBundle\Form\DireccionType($object), array('mapped' => false))
                ->add('indicativo', null, array('attr' => array('style' => 'max-width:45%')))
                ->add('telefono')
                ->add('celular',null,array('constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )))
                ->add('nit', null, array('label' => 'NIT (Con dígito de verificación)'))
                ->add('correo_electronico')
                ->add('nombre_replegal', null, array('label' => 'Nombre del representante legal'))
                ->add('cedula_replegal', null, array('label' => 'Cédula del representante legal'))
                ->add('tipoCliente')
                ->add('estrato')
                ->add('fecha_inicio_facturacion', 'sonata_type_date_picker', array(
                    "label" => "Fecha de inicio de facturación",
                    'dp_language' => 'es',
                    "required" => true,
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'class' => 'form-control',
            )))
                ->add('forma_pago')
                ->add('observaciones')
                ->add('valor_a_pagar', null, array('label' => 'Valor a pagar $'))
                ->add('generar_factura', 'choice', array(
                    'mapped' => false,
                    'label' => '¿Generar factura?',
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
                ->add('crear_centro_de_costo', 'choice', array(
                    'mapped' => false,
                    'label' => '¿Crear centro de costo?',
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
            ->add('exentopago', 'choice', array(
                    'label' => '¿Exento de pago?',
                    'choices' => array(
                        'Sí' => true,
                        'No' => false
                    ),
                    'choices_as_values' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'choice_value' => function ($currentChoiceKey) {
                return $currentChoiceKey ? 'true' : 'false';
            },))
        ;
        $propertyPath = 'municipio';
        $builder
                ->addEventSubscriber(new AddPaisFieldSubscriber($propertyPath, $container))
                ->addEventSubscriber(new AddDepartamentoFieldSubscriber($propertyPath, $container))
                ->addEventSubscriber(new AddMunicipioFieldSubscriber($propertyPath, $container))
                ->addEventSubscriber(new AddZonaFieldSubscriber($propertyPath, $container));
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ModelBundle\Entity\Cliente'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'cliente';
    }

}
