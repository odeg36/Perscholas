<?php

namespace ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DireccionType extends AbstractType {

    private $object;

    public function __construct($object = null) {
        $this->object = $object;
    }

    protected static $choices_tipo_via = array(
        '' => '',
        'Autopista' => 'Autopista',
        'Avenida' => 'Avenida',
        'Calle' => 'Calle',
        'Carrera' => 'Carrera',
        'Diagonal' => 'Diagonal',
        'Transversal' => 'Transversal'
    );
    protected static $choices_cuadrante = array(
        '' => '',
        'Norte' => 'Norte',
        'Oeste' => 'Oeste',
        'Oriente' => 'Oriente',
        'Sur' => 'Sur'
    );
    protected static $choices_prefijo = array('' => '', 'BIS' => 'BIS');
    protected static $choices_sufijo = array('' => '', 'BIS' => 'BIS');

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $object = $this->object;
        $letras = array();
        $letras[null] = null;
        for ($i = "A"; $i != "AA"; $i++) {
            $letras[$i] = $i;
        }
        $noBlank = array(
            new \Symfony\Component\Validator\Constraints\NotBlank(),
        );
        if ($object->getId()) {
            $noBlank = array();
        }
        $builder->add('tipo_via', 'choice', array(
            'constraints' => $noBlank,
            'choices' => self::$choices_tipo_via,
            'attr' => array(
                'onchange' => 'actualizarDireccion();'
            )
        ));
        $builder->add('numero_via', 'text', array(
            'constraints' => $noBlank,
            'attr' => array(
                'oninput' => 'actualizarDireccion();'
            )
        ));
        $builder->add('letra_prefijo', 'choice', array(
            'choices' => $letras,
            'attr' => array(
                'onchange' => 'actualizarDireccion();'
            )
        ));
        $builder->add('prefijo', 'choice', array(
            'choices' => self::$choices_prefijo,
            'attr' => array(
                'onchange' => 'actualizarDireccion();'
            )
        ));
        $builder->add('cuadrante', 'choice', array(
            'choices' => self::$choices_cuadrante,
            'attr' => array(
                'onchange' => 'actualizarDireccion();'
            )
        ));
        $builder->add('numero_generador', 'text', array(
            'constraints' => $noBlank,
            'attr' => array(
                'style' => 'width:90%;float:right;',
                'oninput' => 'actualizarDireccion();'
            )
        ));
        $builder->add('letra_sufijo', 'choice', array(
            'choices' => $letras,
            'attr' => array(
                'onchange' => 'actualizarDireccion();'
            )
        ));
        $builder->add('sufijo', 'choice', array(
            'choices' => self::$choices_sufijo,
            'attr' => array(
                'onchange' => 'actualizarDireccion();'
            )
        ));
        $builder->add('numero_placa', 'text', array(
            'constraints' => $noBlank,
            'attr' => array(
                'oninput' => 'actualizarDireccion();'
            )
        ));
    }

    public function getParent() {
        return 'form';
    }

    public function getName() {
        return 'direccion';
    }

}
