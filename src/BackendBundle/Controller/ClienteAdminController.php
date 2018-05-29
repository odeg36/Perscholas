<?php

namespace BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use BackendBundle\Form\Type\ClienteFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClienteAdminController extends CRUDController {

    /**
     * @param Request $request
     * @return Response
     */
    public function exportAction(Request $request = null) {
        /* @var CRUDController $this */
        try {
            return parent::exportAction($request);
        } catch (\RuntimeException $e) {
            $format = $request->get('format');

            $filename = sprintf(
                    'export_%s_%s.%s', strtolower(substr($this->admin->getClass(), strripos($this->admin->getClass(), '\\') + 1)), date('Y_m_d_H_i_s', strtotime('now')), $format
            );

            $html = $this->renderView(':ExtraExport:CRUD/list.html.twig', [
                'admin' => $this->admin,
                'admin_pool' => $this->get('sonata.admin.pool')
            ]);

            switch ($format) {
                case 'pdf':
                    return new Response(
                            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, $this->getPdfOptions()), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                            ]
                    );
                    break;
                case 'jpg':
                    return new Response(
                            $this->get('knp_snappy.image')->getOutputFromHtml($html, $this->getJpgOptions()), 200, [
                        'Content-Type' => 'image/jpeg',
                        'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                            ]
                    );
                    break;
                default:
                    throw $e;
            }
        }
    }

    protected function getJpgOptions() {
        return ['width' => 2480, 'height' => 3508];
    }

    protected function getPdfOptions() {
//        return ['orientation' => 'landscape'];
        return [];
    }

    /**
     * Create action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction() {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new ClienteFormType($this->container), $object);
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                try {
                    $em = $this->getDoctrine()->getManager();
                    $object = $this->admin->create($object);
                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                    if ($form->get('generar_factura')->getData()) {
                        $cliente = $object;
                        $formaPago = $cliente->getFormaPago();
                        if ($formaPago) {
                            try {
                                $nombreFactura = $cliente->getNombre() . "_" . date('Y_m_d') . "__" . rand(0, 10000) . ".pdf";
                                $newFactura = new \ModelBundle\Entity\Facturacion();
                                $newFactura->setCliente($cliente);
                                $newFactura->setValorAPagar($cliente->getValorAPagar());
                                $this->container->get('knp_snappy.pdf')->generateFromHtml(
                                        $this->renderView(
                                                'ModelBundle:Cliente:factura.html.twig', array(
                                            'cliente' => $cliente,
                                            'factura' => $newFactura,
                                            'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                                )
                                        ), $this->container->get('kernel')->getRootDir() . '/../web/uploads/facturas/' . $nombreFactura
                                );
                                $newFactura->setFactura($nombreFactura);
                                $em->persist($newFactura);
                                $now = new \DateTime();
                                $mensaje = "Grünberta generó su factura correspondiente a la fecha " . $now->format('Y-m-d');
                                $usuarios = $cliente->getUsuarios();
                                foreach ($usuarios as $usuario) {
                                    $newAlerta = new \ModelBundle\Entity\Alerta();
                                    $newAlerta->setMensaje($mensaje);
                                    $newAlerta->setUsuario($usuario);
                                    $em->persist($newAlerta);
                                }
                                $em->flush();
                            } catch (\Exception $e) {
                                echo ($e->getMessage() . "\n\n");
                            }
                        } else {
                            $this->addFlash(
                                    'sonata_flash_error', 'Para generar la factura, es necesario definir la forma de pago.'
                            );
                        }
                    }
                    if ($form->get('crear_centro_de_costo')->getData()) {
                        $cliente = $object;
                        $newCentroCosto = new \ModelBundle\Entity\CentroRecoleccion();
                        $newCentroCosto->setActivo(true);
                        $newCentroCosto->setCelular($cliente->getCelular());
                        $newCentroCosto->setCliente($cliente);
                        $newCentroCosto->setDireccion($cliente->getDireccion());
                        $newCentroCosto->setNombre($cliente->getNombre());
                        $newCentroCosto->setTelefono($cliente->getTelefono());
                        $em->persist($newCentroCosto);
                        $em->flush();
                    }
                    if ($form->get('generar_factura')->getData() && $form->get('crear_centro_de_costo')->getData()) {
                        return $this->redirect(
                                        $this->generateUrl('admin_model_centrorecoleccion_edit', array(
                                            'id' => $newCentroCosto->getId()
                                        ))
                        );
                    }
                    if ($form->get('generar_factura')->getData()) {
                        return $this->redirect($this->generateUrl('admin_model_facturacion_list')
                                        . "?filter[fechaCreacion][type]=&filter[fechaCreacion][value][start]=&filter[fechaCreacion][value][end]=&filter[cliente][type]=&filter[cliente][value]=" . $cliente->getId() . "&filter[valor_a_pagar][type]=&filter[valor_a_pagar][value]=&filter[_page]=1&filter[_sort_by]=fechaCreacion&filter[_sort_order]=DESC&filter[_per_page]=32");
                    }
                    if ($form->get('crear_centro_de_costo')->getData()) {
                        return $this->redirect(
                                        $this->generateUrl('admin_model_centrorecoleccion_edit', array(
                                            'id' => $newCentroCosto->getId()
                                        ))
                        );
                    }
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }
                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                            'sonata_flash_error', $this->admin->trans(
                                    'flash_create_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());
        $em = $this->getDoctrine()->getManager();
        $tipos_residuos = $em->getRepository('ModelBundle:TipoResiduo')->findAllArray();
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
                    'tipos_residuos' => $tipos_residuos
        ));
    }

    /**
     * Edit action.
     *
     * @param int|string|null $id
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function editAction($id = null) {
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('EDIT', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new ClienteFormType($this->container), $object);
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $em = $this->getDoctrine()->getManager();
                    $object = $this->admin->update($object);
                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_edit_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                    if ($form->get('generar_factura')->getData()) {
                        $cliente = $object;
                        $formaPago = $cliente->getFormaPago();
                        if ($formaPago) {
                            try {
                                $nombreFactura = $cliente->getNombre() . "_" . date('Y_m_d') . "__" . rand(0, 10000) . ".pdf";
                                $newFactura = new \ModelBundle\Entity\Facturacion();
                                $newFactura->setCliente($cliente);
                                $newFactura->setValorAPagar($cliente->getValorAPagar());
                                $this->container->get('knp_snappy.pdf')->generateFromHtml(
                                        $this->renderView(
                                                'ModelBundle:Cliente:factura.html.twig', array(
                                            'cliente' => $cliente,
                                            'factura' => $newFactura,
                                            'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                                )
                                        ), $this->container->get('kernel')->getRootDir() . '/../web/uploads/facturas/' . $nombreFactura
                                );
                                $newFactura->setFactura($nombreFactura);
                                $em->persist($newFactura);
                                $now = new \DateTime();
                                $mensaje = "Grünberta generó su factura correspondiente a la fecha " . $now->format('Y-m-d');
                                $usuarios = $cliente->getUsuarios();
                                foreach ($usuarios as $usuario) {
                                    $newAlerta = new \ModelBundle\Entity\Alerta();
                                    $newAlerta->setMensaje($mensaje);
                                    $newAlerta->setUsuario($usuario);
                                    $em->persist($newAlerta);
                                }
                                $em->flush();
                            } catch (\Exception $e) {
                                echo ($e->getMessage() . "\n\n");
                                exit;
                            }
                        } else {
                            $this->addFlash(
                                    'sonata_flash_error', 'Para generar la factura, es necesario definir la forma de pago.'
                            );
                        }
                    }
                    if ($form->get('crear_centro_de_costo')->getData()) {
                        $cliente = $object;
                        $newCentroCosto = new \ModelBundle\Entity\CentroRecoleccion();
                        $newCentroCosto->setActivo(true);
                        $newCentroCosto->setCelular($cliente->getCelular());
                        $newCentroCosto->setCliente($cliente);
                        $newCentroCosto->setDireccion($cliente->getDireccion());
                        $newCentroCosto->setNombre($cliente->getNombre());
                        $newCentroCosto->setTelefono($cliente->getTelefono());
                        $em->persist($newCentroCosto);
                        $em->flush();
                    }
                    if ($form->get('generar_factura')->getData() && $form->get('crear_centro_de_costo')->getData()) {
                        return $this->redirect(
                                        $this->generateUrl('admin_model_centrorecoleccion_edit', array(
                                            'id' => $newCentroCosto->getId()
                                        ))
                        );
                    }
                    if ($form->get('generar_factura')->getData()) {
                        return $this->redirect($this->generateUrl('admin_model_facturacion_list')
                                        . "?filter[fechaCreacion][type]=&filter[fechaCreacion][value][start]=&filter[fechaCreacion][value][end]=&filter[cliente][type]=&filter[cliente][value]=" . $cliente->getId() . "&filter[valor_a_pagar][type]=&filter[valor_a_pagar][value]=&filter[_page]=1&filter[_sort_by]=fechaCreacion&filter[_sort_order]=DESC&filter[_per_page]=32");
                    }
                    if ($form->get('crear_centro_de_costo')->getData()) {
                        return $this->redirect(
                                        $this->generateUrl('admin_model_centrorecoleccion_edit', array(
                                            'id' => $newCentroCosto->getId()
                                        ))
                        );
                    }
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }
                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                            'sonata_flash_error', $this->admin->trans(
                                    'flash_edit_error', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
        ));
    }

}
