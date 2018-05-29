<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ResiduoAdmin extends Admin {

    
    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('tipo_residuo')
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre', null, array('label' => 'Nombre'))
                ->add('densidad')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('tipo_residuo')
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre', null, array('label' => 'Nombre'))
                ->add('_action', 'actions', array('label' => 'Acción',
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
        $formMapper
                ->add('tipo_residuo')
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre', null, array('label' => 'Nombre'))
                ->add('densidad')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('tipo_residuo')
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre', null, array('label' => 'Nombre'))
                ->add('densidad')
        ;
    }

}
