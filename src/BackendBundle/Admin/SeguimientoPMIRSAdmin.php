<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SeguimientoPMIRSAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
//        $datagridMapper
//            ->add('nombre')
//        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('centro_recoleccion.cliente', null, array('label' => 'Cliente'))
                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
                ->add('cumple_seguimiento', null, array('label' => '¿Cumple con el seguimiento?'))
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
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('centro_recoleccion.cliente', null, array('label' => 'Cliente'))
                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
                ->add('cumple_seguimiento', null, array('label' => '¿Cumple con el seguimiento?'))
                ->add('preguntas', null, array('template' => 'BackendBundle:Seguimiento:mostrarPreguntas.html.twig'))
        ;
    }

    public function createQuery($context = 'list') {
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken() ? $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser() : null;
        $query = parent::createQuery($context);
        if ($user && $user->getCliente()) {
            $query->join($query->getRootAliases()[0] . '.centro_recoleccion', 'cc');
            $query->join('cc.cliente', 'c');
            $query->andWhere(
                    $query->expr()->eq('c.id', ':cliente')
            );
            $query->setParameter('cliente', $user->getCliente()->getId());
        }
        return $query;
    }

    public function getTemplate($name) {

        switch ($name) {
            case 'create':
            case 'edit':
                return 'BackendBundle:Seguimiento:base_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
