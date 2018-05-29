<?php

namespace BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class CentroRecoleccionFormType extends AbstractType {

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
        $centroRecoleccion = $builder->getData();
        $data = $centroRecoleccion->getId() && $centroRecoleccion->getCliente()->getTipoCliente() ? $centroRecoleccion->getCliente()->getTipoCliente()->getNombre() : '';
        $formOptions = array();
        $user = $container->get('security.context')->getToken() ? $container->get('security.context')->getToken()->getUser() : null;
        if ($user && $user->hasRole('ROLE_GESTOR') && $user->getCliente()) {
            $cliente = $user->getCliente();
            $data = $cliente->getTipoCliente();
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

        $builder
                ->add('cliente', null, $formOptions)
                ->add('nombre', null, array(
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )
                ))
                ->add('nombreContacto', null, array('label' => 'Nombre del contacto',
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )
                ))
                ->add('cargoContacto', null, array('label' => 'Cargo del contacto'))
                ->add('activo')
                ->add('direccion', 'text', array(
                    'label' => 'Dirección',
                    'attr' => array('readonly' => true),
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )
                ))
                ->add('direccion_format', new \ModelBundle\Form\DireccionType($centroRecoleccion), array('mapped' => false))
                ->add('telefono', null, array(
                    'label' => 'Teléfono',
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\Length(array('min' => 7, 'minMessage' => 'El número de teléfono debe ser de al menos 7 dígitos')),
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )
                ))
                ->add('celular', null, array(
                    'required' => true,
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\Length(array('min' => 10, 'minMessage' => 'El número de celular debe ser de al menos 10 dígitos'))
                    )
                ))
                ->add('tipo_de_cliente', 'text', array(
                    'required' => true,
                    'label' => 'Tipo de cliente', 'mapped' => false, 'data' => $data, 'disabled' => true))
        ;
        if ($centroRecoleccion->getId() && $centroRecoleccion->getCliente()->getTipoCliente() || ($user && $user->hasRole('ROLE_GESTOR') && $user->getCliente())) {
            if ($user && $user->getCliente()) {
                $tipo = $user->getCliente()->getTipoCliente();
            } else {
                $tipo = $centroRecoleccion->getCliente()->getTipoCliente();
            }
            if (
                    $tipo->getNombre() == "Constructora" ||
                    $tipo->getNombre() == "Oficina" ||
                    $tipo->getNombre() == "Hospital/Clínica" ||
                    $tipo->getNombre() == "Empresa" ||
                    $tipo->getNombre() == "Institución educativa"
            ) {
                $builder->add('numero_empleados', null, array('label' => 'Número de empleados'));
            }
            if ($tipo->getNombre() == "Hospital/Clínica") {
                $builder->add('numero_camillas', null, array('label' => 'Número de camillas'));
            }
            if (
                    $tipo->getNombre() == "Centro comercial" ||
                    $tipo->getNombre() == "Urbanización o similares"
            ) {
                $builder->add('numero_locales', null, array('label' => 'Número de locales'));
            }
            if ($tipo->getNombre() == "Urbanización o similares") {
                $builder->add('numero_apartamentos', null, array('label' => 'Número de apartamentos'));
                $builder->add('numero_promedio_habitantes_apartamento', null, array('label' => 'Número promedio de habitantes por apartamento'));
                $builder->add('numero_torres', null, array('label' => 'Número de bloques'));
            }
            if ($tipo->getNombre() == "Institución educativa") {
                $builder->add('numero_estudiantes', null, array('label' => 'Número de estudiantes'));
            }
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ModelBundle\Entity\CentroRecoleccion'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'centro_recoleccion';
    }

}
