<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EncuestaSeguimientoPMIRSAdmin extends Admin{
    
    
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
//            ->add('observaciones')
//            ->add('conclusionesObservacionees')
//            ->add('atendio')
//            ->add('elaboro')
//        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('centro_recoleccion', null, array('label' => 'Centro de Recolección'))
            ->add('observaciones', null, array('label' => 'Observaciones'))
            ->add('conclusionesObservacionees', null, array('label' => 'Conclusiones'))
            ->add('atendio', null, array('label' => 'Atendió'))
            ->add('elaboro', null, array('label' => 'Elaboró'))
            ->add('archivoEncuesta', null, array('label' => 'Archivo', 'template' => 'BackendBundle:Images:lista_pmirs.html.twig', 'value' => 'value', 'label' => 'Archivo'))
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
            ->add('centro_recoleccion', null, array('label' => 'Centro de Recolección'))
            ->add('observaciones', null, array('label' => 'Observaciones'))
            ->add('conclusionesObservacionees', null, array('label' => 'Conclusiones'))
            ->add('atendio', null, array('label' => 'Atendió'))
            ->add('elaboro', null, array('label' => 'Elaboró'))
            ->add('archivoEncuesta', 'file', array("data_class" => null, 'required' => false, 'label' => 'Archivo'));
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('centro_recoleccion', null, array('label' => 'Centro de Recolección'))
            ->add('observaciones', null, array('label' => 'Observaciones'))
            ->add('conclusionesObservacionees', null, array('label' => 'Conclusiones'))
            ->add('atendio', null, array('label' => 'Atendió'))
            ->add('elaboro', null, array('label' => 'Elaboró'))
            ->add('archivoEncuesta', 'file', array('Archivo' => 'Archivo', "data_class" => null, 'required' => false))
        ;
    }

    public function preUpdate($object) {
        $file = $object->getarchivoEncuesta();
        

        if($file != NULL)
        {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getConfigurationPool()->getContainer()->getParameter('directorio_pmirs'), $fileName
            );
            $object->setArchivoEncuesta($fileName);
        }
        else
        {
            $object->setArchivoEncuesta("N/A");
        }
    }
}