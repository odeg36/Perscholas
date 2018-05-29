<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class RChecklistFormType extends AbstractType {

    public $container;

    public function __construct($container = null) {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $container = $this->container;
        $cliente = null;
        if ($container) {
            $token = $container->get('security.context')->getToken();
            $user = $token ? $token->getUser() : null;
            if ($user && $user->getCliente()) {
                $cliente = $user->getCliente();
            }
            if ($user->hasRole('ROLE_GESTOR')) {
                $disabled = true;
            } else {
                $disabled = false;
            }
        }

        $builder
                ->add('cliente', "entity", array(
                    "label" => "Cliente",
                    'class' => 'ModelBundle:Cliente',
                    'data' => $cliente,
                    "empty_value" => "",
                    "required" => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'disabled' => $disabled,
                    )
                ))
                ->add('centro_costo', 'hidden', array(
                    'mapped' => false
                ))
                ->add('fecha_inicial', 'sonata_type_date_picker', array(
                    "label" => "Fecha inicial de recolección",
                    'dp_language' => 'es',
                    'format' => 'dd/MM/yyyy',
                    "required" => false,
                    'attr' => array(
                        'class' => 'form-control',
            )))
                ->add('imagen_grafica', 'hidden', array())
                ->add('fecha_final', 'sonata_type_date_picker', array(
                    "label" => "Fecha final de recolección",
                    'dp_language' => 'es',
                    'format' => 'dd/MM/yyyy',
                    "required" => false,
                    'attr' => array(
                        'class' => 'form-control',
        )));
    }

}
