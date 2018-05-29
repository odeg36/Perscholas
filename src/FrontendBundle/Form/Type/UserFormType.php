<?php

namespace FrontendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $notBlanck = array(
            new NotBlank(array(
                'message' => 'El campo no puede estar vacío.',
            ))
        );
        
        $builder
            ->add('firstname', null, array(
                "label" => "Nombres *",
                "required" => true,
                "constraints" => $notBlanck
            ))
            ->add('lastname', null, array(
                "label" => "Apellidos *",
                "required" => true,
                "constraints" => $notBlanck
            ))
            ->add('gender', "choice", array(
                "label" => "Genero *",
                "empty_value" => "Genero",
                "required" => true,
                "choices" => array(
                    "M" => "Masculino",
                    "F" => "Femenino"
                ),
                "constraints" => $notBlanck
            ))
            ->add('dateOfBirth', null, array(
                "label" => "Fecha de nacimiento *",
                "required" => true,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                ),
                "constraints" => $notBlanck
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModelBundle\Entity\User'
        ));
    }
}