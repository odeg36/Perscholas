<?php

namespace BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClienteAdmin extends Admin {

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
                ->add('tipoCliente')
                ->add('nit')
                ->add('correo_electronico')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('nombre', null, array('label' => 'Nombre'))
                ->add('tipoCliente', null, array('label' => 'Tipo de cliente'))
                ->add('nit', null, array('label' => 'NIT'))
                ->add('correo_electronico', null, array('label' => 'Correo electrónico'))
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
//                ->with("Datos generales")
//                ->add('nombre', null, array('label' => 'Nombre'))
//                ->add('nit', null, array('label' => 'NIT (Con dígito de verificación)'))
//                ->add('correo_electronico', null, array('label' => 'Correo electrónico'))
//                ->add('cedula_replegal', null, array('label' => 'Cédula del representante legal', 'required' => false))
//                ->add('zona', null, array('label' => 'Zona'))
//                ->add('estrato', null, array('label' => 'Estrato'))
//                ->add('direccion', null, array('label' => 'Dirección'))
//                ->add('telefono', 'text', array('label' => 'Teléfono'))
//                ->add('tipoCliente', null, array(
//                    'attr' => array('class' => 'tipo_cliente'),
//                    'label' => 'Tipo de cliente',
//                    'empty_value' => ""
//                ))
//                ->end()
//                ->with("Unidad residencial", array('class' => 'unidad_residencial'))
//                ->add('numero_torres', null, array("required" => false, 'label' => 'Número de torres'))
//                ->add('numero_apartamentos', null, array("required" => false, 'label' => 'Número de apartamento'))
//                ->add('tiene_locales')
//                ->end()
//        ;
//    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('nombre')
                ->add('direccion')
                ->add('municipio.departamento.pais')
                ->add('municipio.departamento')
                ->add('municipio')
                ->add('zona')
                ->add('estrato')
                ->add('indicativo', null, array('attr' => array('style' => 'max-width:22%')))
                ->add('telefono')
                ->add('celular')
                ->add('correo_electronico')
                ->add('nit', null, array('label' => 'NIT (Con dígito de verificación)'))
                ->add('cedula_replegal', null, array('label' => 'Cédula del representante legal'))
                ->add('tipoCliente')
                ->add('numero_torres')
                ->add('numero_apartamentos')
                ->add('tiene_locales')
        ;
    }

    public function createQuery($context = 'list') {
        $usuario = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $rol = $usuario->getRoles();
        $query = parent::createQuery($context);

        if ($rol[0] != "ROLE_SONATA_ADMIN") {
            $query->andWhere(
                    $query->expr()->eq($query->getRootAliases()[0] . '.id', ':id')
            );
            $query->setParameter('id', $usuario);
            return $query;
        } else {
            return $query;
        }
    }

    public function getTemplate($name) {

        switch ($name) {
            case 'create':
            case 'edit':
                return 'BackendBundle:Cliente:base_edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

}
