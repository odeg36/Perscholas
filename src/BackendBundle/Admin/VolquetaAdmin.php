<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;

class VolquetaAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('nombre')
                ->add('volumen', null, array('label' => 'Volumen m3'));
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
         $listMapper
                ->add('nombre')
                ->add('volumen', null, array('label' => 'Volumen m3','template'=>'BackendBundle:Contenedor:volumen.html.twig'))
                ->add('_action', 'actions', array('label' => 'Acción',
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('nombre')
            ->add('volumen', null, array('label' => 'Volumen m3'));
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
            ->add('nombre')
            ->add('volumen', null, array('label' => 'Volumen m3','template'=>'BackendBundle:Contenedor:volumen.html.twig'))
        ;
    }
}
