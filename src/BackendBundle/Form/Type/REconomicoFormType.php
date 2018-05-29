<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;

class REconomicoFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $notBlank = array(new NotBlank(array('message' => 'El campo no puede estar vacío.')));
        $builder
                ->add('cliente', 'entity', 
                        array(
                            "label" => "Cliente", 
                            'class' => 'ModelBundle:Cliente',
                            "empty_value" => "", 
                            'disabled' => true,
                            'attr' => array(
                                'class' => 'cliente_reporte form-control',
                                "required" => true, 
                                )))
                ->add('anio', null, 
                        array(
                            "label" => "Año", 
                            'attr' => array(
                                'class' => 'anio_reporte form-control',
                                "required" => true, 
                                )));
    }
}
