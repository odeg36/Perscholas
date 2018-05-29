<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;

class TipoResiduoAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre')
                ->add('disposicion', null, array('label' => 'Disposición'))
                ->add('validar_disposicion', null, array('label' => '¿Validar certificado de disposición?'))
                ->add('usa_contenedor', null, array('label' => '¿Usa contenedor?'))
                ->add('usa_volqueta', null, array('label' => '¿Usa vehículo?'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('color', null, array('template' => 'BackendBundle:Residuo:lista_residuo.html.twig'))
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre')
                ->add('disposicion', null, array('label' => 'Disposición'))
                ->add('validar_disposicion', null, array('label' => '¿Validar certificado de disposición?'))
                ->add('usa_contenedor', null, array('label' => '¿Usa contenedor?'))
                ->add('usa_volqueta', null, array('label' => '¿Usa vehículo?'))
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
                ->add('color', null, array('attr' => array('class' => 'jscolor')))
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre')
                ->add('disposicion', null, array(
                    'label' => 'Disposición',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('r')
                                ->where('r.disposicion is null');
                    },
                ))
                ->add('validar_disposicion', null, array('label' => '¿Validar certificado de disposición?'))
                ->add('usa_contenedor', null, array('label' => '¿Usa contenedor?'))
                ->add('usa_volqueta', null, array('label' => '¿Usa vehículo?'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('color', null, array('attr' => array('class' => 'jscolor')))
                ->add('codigo', null, array('label' => 'Código'))
                ->add('nombre')
                ->add('disposicion', null, array('label' => 'Disposición'))
                ->add('validar_disposicion', null, array('label' => '¿Validar certificado de disposición?'))
                ->add('usa_contenedor', null, array('label' => '¿Usa contenedor?'))
                ->add('usa_volqueta', null, array('label' => '¿Usa vehículo?'))
                ->add('residuos')
        ;
    }

}
