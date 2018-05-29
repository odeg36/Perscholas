<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AlertaAdmin extends Admin
{
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
//            ->add('eventoAsosciado')
//            ->add('estado')
//            ->add('estadoNotificacion')
//            ->add('reglaAplicada')
//            ->add('comentario')
//            ->add('fechaCreacion')
//        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('tipoNotificacion')
            ->add('tipoAlerta')
            ->add('eventoAsosciado')
            ->add('estado')
            ->add('estadoNotificacion')
            ->add('reglaAplicada')
            ->add('comentario')
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
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('usuario', null, array('label' => 'Usuario'))
            ->add('tipoAlerta', null, array('label' => 'Tipo de alerta'))
            ->add('eventoAsosciado', null, array('label' => 'Evento de asociado'))
            ->add('reglaAplicada', null, array('label' => 'Regla aplicada'))
            ->add('estado', null, array('label' => 'Estado'))
            ->add('estadoNotificacion', null, array('label' => 'Estado de notificación'))
            ->add('comentario', null, array('label' => 'Comentario'))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('usuario', null, array('label' => 'Usuario'))
            ->add('tipoAlerta', null, array('label' => 'Tipo de alerta'))
            ->add('eventoAsosciado', null, array('label' => 'Evento de asociado'))
            ->add('reglaAplicada', null, array('label' => 'Regla aplicada'))
            ->add('estado', null, array('label' => 'Estado'))
            ->add('estadoNotificacion', null, array('label' => 'Estado de notificación'))
            ->add('comentario', null, array('label' => 'Comentarios'))
        ;
    }
}
