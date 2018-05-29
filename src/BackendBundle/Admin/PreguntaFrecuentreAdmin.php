<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PreguntaFrecuentreAdmin extends AbstractAdmin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('pregunta')
                ->add('respuesta')
                ->add('roles')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('pregunta')
                ->add('respuesta')
                ->add('roles', null, array("template" => "BackendBundle:ManualUsuario:roles.html.twig", 'label' => 'Roles'))
                ->add('_action', null, array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $choices = array();
        foreach ($this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles') as $key => $rol) {
            if ($key != "ROLE_SONATA_ADMIN") {
                $choices["$rol[0]"] = $rol[0];
            }
        }
        $formMapper
                ->add('pregunta')
                ->add('respuesta')
                ->add('roles', "choice", array(
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true,
                    'choices' => $choices
                ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('pregunta')
                ->add('respuesta')
                ->add('roles', null, array("template" => "BackendBundle:ManualUsuario:roles.html.twig", 'label' => 'Roles'))
        ;
    }

}
