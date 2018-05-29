<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TarifaDescuentoAdmin extends Admin{
    
    
    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
//        $datagridMapper
//            ->add('nombre')
//            ->add('precioMaterial')
//            ->add('minimo')
//            ->add('maximo')
//            ->add('descuento')
//            ->add('fechaInicio')
//            ->add('fechaFinal')
//        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('nombre')
            ->add('precioMaterial')
            ->add('minimo')
            ->add('maximo')
            ->add('descuento')
            ->add('fechaInicio')
            ->add('fechaFinal')
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('precioMaterial')
            ->add('minimo', 'text')
            ->add('maximo', 'text')
            ->add('descuento')
            ->add('fechaInicio', 'sonata_type_datetime_picker', array(
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                "attr" => array(
                    "readonly" => "readonly"
                )
            ))
            ->add('fechaFinal', 'sonata_type_datetime_picker', array(
                'dp_language'=>'fr',
                'format'=>'dd/MM/yyyy',
                "attr" => array(
                    "readonly" => "readonly"
                )
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nombre')
            ->add('precioMaterial')
            ->add('minimo')
            ->add('maximo')
            ->add('descuento')
            ->add('fechaInicio')
            ->add('fechaFinal')
        ;
    }
}
