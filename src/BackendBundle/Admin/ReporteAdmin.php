<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ReporteAdmin extends Admin {

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
//        $datagridMapper
//            ->add('consultaReporte')
//            ->add('fechaCreacion')
//        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('consultaReporte')
                ->add('fechaCreacion')
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
//        $formMapper
//            ->add('consultaReporte')
//            ->add('fechaCreacion')
//        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('consultaReporte')
                ->add('fechaCreacion')
        ;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        parent::configureRoutes($collection);

        $collection
                ->remove('create')
                ->remove('list')
                ->remove('edit')
                ->remove('delete')
        ;
        $collection
                ->add('detallado', 'detallado')
                ->add('checklist', 'checklist')
                ->add('operativo', 'operativo')
                ->add('economico', 'economico')
                ->add('capacitaciones', 'capacitaciones')
                ->add('residuosDisposicion', 'residuosDisposicion');
    }

}
