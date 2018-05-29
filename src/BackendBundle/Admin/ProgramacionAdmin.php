<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProgramacionAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollection $collection) {
        $collection->add('copia', $this->getRouterIdParameter() . '/copia');
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
                    ),
                    'label' => 'Fecha de creación'
                ))
                ->add('centro_recoleccion.cliente', null, array('label' => 'Cliente'))
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

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('fechaCreacion', null, array('label' => 'Fecha de creación'))
                ->add('centro_recoleccion.cliente', null, array('label' => 'Cliente'))
                ->add('centro_recoleccion', null, array('label' => 'Centro de costo'))
                ->add('tipos_residuos_transporte', null, array('label' => 'Tipos de residuos', 'template' => 'BackendBundle:Programacion:tiposResiduos.html.twig'))
                ->add('validada', null, array('label' => 'Validada', 'template' => 'BackendBundle:Programacion:list_validada.html.twig'))
                ->add('_action', 'actions', array('label' => 'Acción',
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                        'copia' => array(
                            'template' => 'BackendBundle:Programacion:list__action_copia.html.twig'
                        )
                    ))
                )
        ;
    }

//    /**
//     * @param FormMapper $formMapper
//     */
//    protected function configureFormFields(FormMapper $formMapper) {
//        $formMapper
//                ->add('fecha_programacion', 'sonata_type_datetime_picker', array(
//                    'label' => 'Fecha de recolección',
//                    'dp_language' => 'es',
//                    'format' => 'dd/MM/yyyy hh:mm',
//                    "attr" => array(
//                        "readonly" => "readonly"
//                    ))
//                )
//                ->add('observacion')
//        ;
//    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('centro_recoleccion.cliente', null, array('label' => 'Cliente'))
                ->add('centro_recoleccion')
                ->add('observacion')
        ;
    }

    public function getTemplate($name) {
        switch ($name) {
            case 'edit':
                return 'BackendBundle:Programacion:base_edit.html.twig';
                break;
            case 'show':
                return 'BackendBundle:Programacion:base_show.html.twig';
                break;

            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
