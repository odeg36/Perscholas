<?php

namespace BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BackendBundle\Form\Type\CapacitacionFormType;

class CapacitacionAdminController extends CRUDController {


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
            $em = $this->container->get("doctrine")->getManager();
            $capacitaciones = $em->getRepository("ModelBundle:Capacitacion")->findAll();

            $html = $this->renderView('BackendBundle:Reportes:lista_capacitaciones.html.twig', ['capacitaciones' => $capacitaciones]);
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

    protected function getJpgOptions() {
        return ['width' => 2480, 'height' => 3508];
    }

    protected function getPdfOptions() {
        return ['orientation' => 'portrait'];
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
        $form = $this->createForm(new CapacitacionFormType($this->container), $object);
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
                    $object->upload($form->get('archivo')->getData());
                    $object->uploade($form->get('evidencia')->getData());
                    $object = $this->admin->create($object);
                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
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
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
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
        $form = $this->createForm(new CapacitacionFormType($this->container), $object);
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $em = $this->getDoctrine()->getManager();
                    $object->upload($form->get('archivo')->getData());
                    $object->uploade($form->get('evidencia')->getData());
                    $object = $this->admin->update($object);
                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_edit_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );
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
