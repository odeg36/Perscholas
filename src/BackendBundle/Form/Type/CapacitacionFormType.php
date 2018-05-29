<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BackendBundle\Form\EventListener\AddClienteFieldSubscriber;
use BackendBundle\Form\EventListener\AddCentroRecoleccionFieldSubscriber;
use BackendBundle\Form\EventListener\AddGestorAmbientalFieldSubscriber;

class CapacitacionFormType extends AbstractType {

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
        $propertyPath = 'centro_recoleccion';
        $builder
                ->addEventSubscriber(new AddClienteFieldSubscriber($propertyPath, $container))
                ->addEventSubscriber(new AddCentroRecoleccionFieldSubscriber($propertyPath, $container));
        $propertyPath = 'gestor';
        $builder->addEventSubscriber(new AddGestorAmbientalFieldSubscriber($propertyPath, $container));
        $builder
                ->add('fechaCapacitacion', 'sonata_type_date_picker', array(
                    'label' => 'Fecha de capacitación',
                    'dp_language' => 'es',
                    'format' => 'dd/MM/yyyy',
                    "attr" => array(
                        "readonly" => "readonly"
                    ))
                )
                ->add('numeroAsistentes', null, array('label' => 'Número de asistenes'))
                ->add('tipoCapacitacion', null, array('label' => 'Tipo de capacitación'))
                ->add('archivo', 'file', array("data_class" => null, 'required' => false, 'label' => 'Certificado de capacitación', 'mapped' => false))
                ->add('evidencia', 'file', array("data_class" => null, 'required' => false, 'label' => 'Evidencia fotográfica', 'mapped' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ModelBundle\Entity\Capacitacion'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'capacitacion';
    }

}
