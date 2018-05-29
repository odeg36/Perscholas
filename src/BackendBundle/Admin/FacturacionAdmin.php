<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FacturacionAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->remove('create');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('fechaCreacion', 'doctrine_orm_date_range', array(
                    'field_type' => 'sonata_type_date_range_picker', 'field_options' => array(
                        'field_options_start' => array(
                            'format' => 'd-M-y'
                        ),
                        'field_options_end' => array(
                            'format' => 'd-M-y'
                        )
                    )
                ))
                ->add('cliente')
                ->add('valor_a_pagar')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('fechaCreacion', null, array('label' => 'Fecha de facturacion'))
                ->add('cliente')
                ->add('valor_a_pagar', null, array('template' => 'BackendBundle:Facturacion:precio.html.twig'))
                ->add('visualizar', null, array('template' => 'BackendBundle:Facturacion:visualizar_factura.html.twig'))
                ->add('factura', null, array('template' => 'BackendBundle:Facturacion:factura.html.twig'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('fechaCreacion', null, array('label' => 'Fecha de facturacion'))
                ->add('cliente')
                ->add('valor_a_pagar')
                ->add('factura', null, array('template' => 'BackendBundle:Facturacion:factura.html.twig'))
        ;
    }

}
