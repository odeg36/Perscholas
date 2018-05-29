<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints as Assert;

class UserAdmin extends Admin {

    protected $baseRouteName = 'admin_usuario';
    protected $baseRoutePattern = 'usuario';

    public function getExportFormats() {
        $formats = parent::getExportFormats();
        return array_merge($formats, array('pdf', 'jpg'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $roles = array(
            'ROLE_SONATA_ADMIN' => 'Super administrador',
            'ROLE_CLIENTE' => 'Cliente',
            'ROLE_GESTOR' => 'Gestor ambiental',
        );
        $datagridMapper
                ->add('firstname', null, array('label' => 'Nombre'))
                ->add('lastname', null, array('label' => 'Apellidos'))
                ->add('username', null, array('label' => 'Usuario'))
                ->add('cliente')
                ->add('email', null, array('label' => 'Correo electrónico'))
                ->add('roles', 'doctrine_orm_callback', array(
                    'data' => $this->getRequest()->query->get('filter') ? array_key_exists('roles', $this->getRequest()->query->get('filter')) ? $this->getRequest()->query->get('filter')['roles']['value'] : null : null,
                    'label' => 'Rol',
                    'show_filter' => true,
                    'field_type' => 'choice',
                    'field_options' => array('choices' => $roles),
                    'callback' => function($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }
                        $queryBuilder->andWhere("o.roles LIKE '%" . $value['value'] . "%'");
                    },
                ))
                ->add('enabled', null, array('label' => 'Activo'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('firstname', null, array('label' => 'Nombre'))
                ->add('lastname', null, array('label' => 'Apellidos'))
                ->add('username', null, array('label' => 'Usuario'))
                ->add('cliente')
                ->add('email', null, array('label' => 'Correo electrónico'))
                ->add('roles', null, array(
                    "label" => 'Rol',
                    "template" => "BackendBundle:User:user.show.roles.html.twig"
                ))
                ->add('enabled', null, array('label' => 'Activo'))
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
        $selectEmpty = 'Seleccionar';
        $user = null;
        if ($this->getSubject()->getId()) {
            $user = $this->getSubject()->getUsuario();
        }
        $choices = array();
        foreach ($this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles') as $rol) {
            $choices["$rol[0]"] = $rol[0];
        }

        $formMapper
                ->with("Personal data", array('class' => 'col col-md-6'))
                ->add('firstname', null, array(
                    "required" => true
                ))
                ->add('lastname')
                ->add('documentId', 'text', array())
                ->add('email', null, array(
                    'constraints' => array(
                        new Assert\Email(array())
                    ),
                ))
                ->add('plainPassword', 'text', array(
                    'label' => 'Contraseña de inicio de sesión.',
                    'required' => $this->getSubject()->getPassword() ? false : true,
                ))
                ->add('phone')
                ->add('direction', null, array('label' => 'Dirección de residencia'))
                ->end()
                ->with("Datos de acceso", array('class' => 'col col-md-6'))
                ->add('cliente', 'entity', array(
                    'empty_value' => "",
                    'class' => 'ModelBundle:Cliente',
                ))
                ->end()
                ->with("Permissions", array('class' => 'col col-md-6'))
                ->add('enabled')
                ->add('locked', null, array('label' => '¿Bloqueado?'))
                ->add('expires_at', 'sonata_type_datetime_picker', array(
                    'required' => false,
                    'label' => 'Expira en',
                    'dp_language' => 'es',
                    'format' => 'dd-MM-yyyy',
                    "attr" => array(
                        "readonly" => "readonly"
                    ))
                )
                ->add('roles', "choice", array(
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true,
                    'choices' => $choices,
                    'attr' => array('isEnabled' => $this->getSubject()->isEnabled())
                ))
                ->add('es_kontrol_grun', 'choice', array(
                    'mapped' => true,
                    'label' => '¿Pertenece a Kontrolgrün?',
                    'choices' => array(
                        'Sí' => true,
                        'No' => false
                    ),
                    'choices_as_values' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'choice_value' => function ($currentChoiceKey) {
                        return $currentChoiceKey ? 'true' : 'false';
                    },
                ))
                ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('lastLogin')
                ->add('locked')
                ->add('expires_at', null, array(
                    'label' => 'Expire en',
                ))
                ->add('roles', null, array(
                    "template" => "BackendBundle:User:user.show.roles.html.twig"
                ))
                ->add('createdAt')
                ->add('updatedAt')
                ->add('firstname')
                ->add('lastname')
                ->add('documentId')
                ->add('phone')
        ;
    }

    public function prePersist($object) {
        parent::prePersist($object);
        $object->setUsername($object->getDocumentId());
    }

}
