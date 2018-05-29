<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\File\File;

class SoporteAdmin extends Admin {

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('cliente')
                ->add('tipoSoporte')
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
                ->add('cliente', null, array('label' => 'Cliente'))
                ->add('tipoSoporte', null, array('label' => 'Tipo de soporte'))
                ->add('archivoSoporte', null, array('template' => 'BackendBundle:Images:lista_soporte.html.twig', 'value' => 'value', 'label' => 'Documento'))
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
        $formOptions = array();
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken() ? $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser() : null;
        if ($user && $user->hasRole('ROLE_GESTOR') && $user->getCliente()) {
            $cliente = $user->getCliente();
            $formOptions['query_builder'] = function (EntityRepository $repository) use ($cliente) {
                $qb = $repository->createQueryBuilder('c')
                        ->where('c.id = :cliente')
                        ->setParameter('cliente', $cliente->getId())
                ;
                return $qb;
            };
            $formOptions['attr'] = array(
                'disabled' => true
            );
        }
        $formMapper
                ->add('cliente', null, $formOptions)
                ->add('descripcion', null, array(
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                    )
                ))
                ->add('tipoSoporte', null, array('label' => 'Tipo soporte'))
                ->add('archivoSoporte', 'file', array('label' => 'Cargar archivo de soporte', "data_class" => null, 'required' => false))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('cliente', null, array('label' => 'Cliente'))
                ->add('tipoSoporte', null, array('label' => 'Tipo de soporte'))
                ->add('descripcion')
                ->add('archivoSoporte', null, array('template' => 'BackendBundle:Images:lista_soporte.html.twig', 'value' => 'value', 'label' => 'Documento'))
        ;
    }

    public function getTemplate($name) {

        switch ($name) {
            case 'create':
            case 'edit':
                return 'BackendBundle:Soporte:base_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $this->preUpdate($object);
    }

    public function preUpdate($object) {
        $em = $this->getConfigurationPool()->getContainer()->get("doctrine")->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT archivo_soporte FROM soporte WHERE id = :id");
        $statement->bindValue('id', $object->getId());
        $statement->execute();
        $results = $statement->fetchAll();
        $file = $object->getArchivoSoporte();

        if ($file != NULL) {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getConfigurationPool()->getContainer()->getParameter('directorio_soportes'), $fileName);
            $object->setArchivoSoporte($fileName);
        } else if ($results) {
            $object->setArchivoSoporte($results[0]['archivo_soporte']);
        }
    }

}
