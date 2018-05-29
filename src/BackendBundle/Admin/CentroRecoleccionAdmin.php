<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;

class CentroRecoleccionAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    protected $baseRoutePattern = 'centro_costo';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('cliente')
                ->add('nombre')
                ->add('nombreContacto')
                ->add('cargoContacto')
                ->add('activo')
        ;
    }

    public function createQuery($context = 'list') {
        $user = $this->configurationPool->getContainer()->get('security.context')->getToken() ? $this->configurationPool->getContainer()->get('security.context')->getToken()->getUser() : null;
        $query = parent::createQuery($context);
        if ($user && $user->getCliente()) {
            $query->andWhere(
                    $query->expr()->eq($query->getRootAliases()[0] . '.cliente', ':cliente')
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
                ->add('cliente')
                ->add('nombre')
                ->add('nombreContacto', null, array('label' => 'Nombre de contacto'))
                ->add('cargoContacto', null, array('label' => 'Cargo de contacto'))
                ->add('activo')
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
//        
//    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('cliente')
                ->add('nombre')
                ->add('nombreContacto')
                ->add('cargoContacto')
                ->add('activo')
        ;
    }

    public function getTemplate($name) {

        switch ($name) {
            case 'create':
            case 'edit':
                return 'BackendBundle:CentroRecoleccion:base_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
