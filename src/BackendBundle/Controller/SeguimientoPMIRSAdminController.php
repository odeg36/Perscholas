<?php

namespace BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Form\Type\SeguimientoPMIRSFormType;

class SeguimientoPMIRSAdminController extends CRUDController {

    protected function getJpgOptions() {
        return ['width' => 2480, 'height' => 3508];
    }

    protected function getPdfOptions() {
//        return ['orientation' => 'landscape'];
        return [];
    }

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
                            $this->get('knp_snappy.pdf')
                                    ->getOutputFromHtml($html, $this->getPdfOptions()), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                            ]
                    );
                    break;
                case 'jpg':
                    return new Response(
                            $this->get('knp_snappy.image')
                                    ->getOutputFromHtml($html, $this->getJpgOptions()), 200, [
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

    /**
     * Create action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction() {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                            'SonataAdminBundle:CRUD:select_subclass.html.twig', array(
                        'base_template' => $this->getBaseTemplate(),
                        'admin' => $this->admin,
                        'action' => 'create',
                            ), null, $request
            );
        }

        $object = $this->admin->getNewInstance();

        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new SeguimientoPMIRSFormType($this->container), $object);
        $form->setData($object);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode($request) || $this->isPreviewApproved($request))) {
                $this->admin->checkAccess('create', $object);

                try {
                    $object = $this->admin->create($object);
                    $requestParams = $this->getRequest()->request->all();
                    $object->upload($form->get('archivo')->getData());
                    $em = $this->getDoctrine()->getManager();
                    foreach ($requestParams as $key => $param) {
                        $splitParam = split('pregunta_', $key);
                        if (count($splitParam) > 1) {
                            $idPregunta = $splitParam[1];
                            $preguntaSeguimiento = $em->getRepository('ModelBundle:PreguntaSeguimiento')->findOneBy(array(
                                'pregunta' => $idPregunta,
                                'seguimiento' => $object,
                            ));
                            if (!$preguntaSeguimiento) {
                                $newPreguntaSeguimiento = new \ModelBundle\Entity\PreguntaSeguimiento();
                                $pregunta = $em->getRepository('ModelBundle:PreguntaPMIRS')->find($idPregunta);
                                $newPreguntaSeguimiento->setPregunta($pregunta);
                                $newPreguntaSeguimiento->setSeguimiento($object);
                            } else {
                                $newPreguntaSeguimiento = $preguntaSeguimiento;
                            }
                            $newPreguntaSeguimiento->setCumple($param['cumple']);
                            $newPreguntaSeguimiento->setObservaciones($param['observacion']);
                            $em->persist($newPreguntaSeguimiento);
                        }
                    }
                    $now = new \DateTime();
                    
                    $mensaje = "Alerta por el no cumplimiento del PMIRS";
                    $usuarios = $object->getCentroRecoleccion()->getCliente()->getUsuarios();
                    
                    foreach ($usuarios as $usuario) {
                        $newAlerta = new \ModelBundle\Entity\Alerta();
                        $newAlerta->setMensaje($mensaje);
                        $newAlerta->setUsuario($usuario);
                        $em->persist($newAlerta);
                    }
                    $em->flush();
                    
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                                        ), 200, array());
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

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
        $componentes = $em->getRepository('ModelBundle:ComponentePMIRS')->findAll();
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
                    'componentes' => $componentes,
                        ), null);
    }

    public function editAction($id = null) {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $this->admin->checkAccess('edit', $object);

        $preResponse = $this->preEdit($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form Form */
        $form = $this->createForm(new SeguimientoPMIRSFormType($this->container), $object);
        $form->setData($object);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $object = $this->admin->update($object);
                    $requestParams = $this->getRequest()->request->all();
                    $object->upload($form->get('archivo')->getData());
                    $em = $this->getDoctrine()->getManager();
                    foreach ($requestParams as $key => $param) {
                        $splitParam = explode('pregunta_', $key);
                        if (count($splitParam) > 1) {
                            $idPregunta = $splitParam[1];
                            $preguntaSeguimiento = $em->getRepository('ModelBundle:PreguntaSeguimiento')->findOneBy(array(
                                'pregunta' => $idPregunta,
                                'seguimiento' => $object,
                            ));
                            if (!$preguntaSeguimiento) {
                                $newPreguntaSeguimiento = new \ModelBundle\Entity\PreguntaSeguimiento();
                                $pregunta = $em->getRepository('ModelBundle:PreguntaPMIRS')->find($idPregunta);
                                $newPreguntaSeguimiento->setPregunta($pregunta);
                                $newPreguntaSeguimiento->setSeguimiento($object);
                            } else {
                                $newPreguntaSeguimiento = $preguntaSeguimiento;
                            }
                            $newPreguntaSeguimiento->setCumple($param['cumple']);
                            $newPreguntaSeguimiento->setObservaciones($param['observacion']);
                            $em->persist($newPreguntaSeguimiento);
                        }
                    }
                    $now = new \DateTime();
                    
                    $mensaje = "Alerta por el no cumplimiento del PMIRS";
                    $usuarios = $object->getCentroRecoleccion()->getCliente()->getUsuarios();
                    
                    foreach ($usuarios as $usuario) {
                        $newAlerta = new \ModelBundle\Entity\Alerta();
                        $newAlerta->setMensaje($mensaje);
                        $newAlerta->setUsuario($usuario);
                        $em->persist($newAlerta);
                    }
                    $em->flush();
                    $em->flush();

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                                    'objectName' => $this->escapeHtml($this->admin->toString($object)),
                                        ), 200, array());
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_edit_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                } catch (LockException $e) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_lock_error', array(
                                '%name%' => $this->escapeHtml($this->admin->toString($object)),
                                '%link_start%' => '<a href="' . $this->admin->generateObjectUrl('edit', $object) . '">',
                                '%link_end%' => '</a>',
                                    ), 'SonataAdminBundle'));
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
        $em = $this->getDoctrine()->getManager();
        $componentes = $em->getRepository('ModelBundle:ComponentePMIRS')->findAll();
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
                    'componentes' => $componentes,
                        ), null);
    }

}
