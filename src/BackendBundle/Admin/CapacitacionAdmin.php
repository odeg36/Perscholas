<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CapacitacionAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('fechaCapacitacion')
                ->add('gestor', null, array('label' => 'Gestor ambiental'))
                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
                ->add('tipoCapacitacion', null, array('label' => 'Tipo de capacitación'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('fechaCapacitacion')
                ->add('gestor', null, array('label' => 'Gestor'))
                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
                ->add('numeroAsistentes', null, array('label' => 'Número de asistenes'))
                ->add('tipoCapacitacion', null, array('label' => 'Tipo de capacitación'))
                ->add('archivoCapacitacion', null, array('template' => 'BackendBundle:Images:lista_capacitaciones.html.twig', 'value' => 'value', 'label' => 'Certificado'))
                ->add('evidenciaFotografica', null, array('template' => 'BackendBundle:Images:evidencia_fotografica.html.twig', 'value' => 'value', 'label' => 'Evidencia'))
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
//    protected function configureFormFields(FormMapper $formMapper) {
//        $formMapper
//                ->add('fechaCapacitacion', 'sonata_type_datetime_picker', array(
//                    'label' => 'Fecha de capacitación',
//                    'dp_language' => 'es',
//                    'format' => 'dd/MM/yyyy',
//                    "attr" => array(
//                        "readonly" => "readonly"
//                    ))
//                )
//                ->add('gestor', null, array('label' => 'Gestor'))
//                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
//                ->add('numeroAsistentes', null, array('label' => 'Número de asistenes'))
//                ->add('tipoCapacitacion', null, array('label' => 'Tipo de capacitación'))
//                ->add('archivoCapacitacion', 'file', array("data_class" => null, 'required' => false, 'label' => 'Archivo'));
//    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('fechaCapacitacion')
                ->add('gestor', null, array('label' => 'Gestor'))
                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
                ->add('numeroAsistentes', null, array('label' => 'Número de asistenes'))
                ->add('tipoCapacitacion', null, array('label' => 'Tipo de capacitación'))
                ->add('archivoCapacitacion', null, array('template' => 'BackendBundle:Capacitacion:darchivo.html.twig', 'value' => 'value', 'label' => 'Certificado'))
                ->add('evidenciaFotografica', null, array('template' => 'BackendBundle:Capacitacion:devidencia.html.twig', 'value' => 'value', 'label' => 'Evidencia'))
        ;
    }
    
    public function getTemplate($name) {

        switch ($name) {
            case 'create':
            case 'edit':
                return 'BackendBundle:Capacitacion:base_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}
