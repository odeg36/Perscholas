<?php

namespace BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use BackendBundle\Form\Type\ProgramacionFormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgramacionAdminController extends CRUDController {

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
        $em = $this->getDoctrine()->getManager();

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new ProgramacionFormType($this->container), $object);
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
                    $archivoSubidos = $this->get('request')->files->all();
                    $requestParams = $this->get('request')->request->all();
                    $user = $em->getRepository('ModelBundle:User')->find($this->get('request')->get('programacion_form')['gestor_ambiental']);
                    $object->setGestorAmbiental($user);
                    $object = $this->admin->create($object);
                    foreach ($requestParams as $key => $value) {
                        if (strpos($key, 'tipo_residuo_') !== false) {
                            $tipo_residuo = $value;
                            $idTipo = $tipo_residuo['id'];
                            $tipoResiduo = $em->getRepository('ModelBundle:TipoResiduo')->find($idTipo);
                            if ($tipoResiduo) {
                                $tipo_residuo_transporte = new \ModelBundle\Entity\TipoResiduoTransporte();
                                $tipo_residuo_transporte->setProgramacion($object);
                                $tipo_residuo_transporte->setTipoResiduo($tipoResiduo);
                                if (array_key_exists($key, $archivoSubidos) && array_key_exists('certificado', $archivoSubidos[$key]) && $archivoSubidos[$key]['certificado']) {
                                    $tipo_residuo_transporte->uploadDisposicion($archivoSubidos[$key]['certificado']);
                                    $tipo_residuo_transporte->setValidado(true);
                                } else {
                                    $tipo_residuo_transporte->setValidado(false);
                                }
                                $em->persist($tipo_residuo_transporte);
                                if (array_key_exists('recoleccion', $tipo_residuo)) {
                                    $recolecciones = $tipo_residuo['recoleccion'];
                                    foreach ($recolecciones as $keyR => $recoleccion) {
                                        $newRecoleccion = new \ModelBundle\Entity\Recoleccion();
                                        $newRecoleccion->setTipoResiduoTransporte($tipo_residuo_transporte);
                                        $fecha_programacion = $recoleccion['fecha_programacion'];
                                        $newRecoleccion->setFechaProgramacion(new \DateTime($fecha_programacion));
                                        $fecha_recoleccion = $recoleccion['fecha_recoleccion'];
                                        $newRecoleccion->setFechaRecoleccionEjecutada(new \DateTime($fecha_recoleccion));
                                        if (
                                                array_key_exists($key, $archivoSubidos) &&
                                                array_key_exists('recoleccion', $archivoSubidos[$key]) &&
                                                array_key_exists($keyR, $archivoSubidos[$key]['recoleccion']) &&
                                                $archivoSubidos[$key]['recoleccion'][$keyR]['manifiesto']
                                        ) {
                                            $newRecoleccion->uploadTransporte($archivoSubidos[$key]['recoleccion'][$keyR]['manifiesto']);
                                        }
                                        $em->persist($newRecoleccion);
                                        if (array_key_exists('tipo_transporte', $recoleccion) && $recoleccion["tipo_transporte"] != "personalizado") {
                                            $tipoTransporte = $recoleccion['tipo_transporte'];
                                            $idTipoTransporte = $recoleccion['id_tipo_transporte'];
                                            $volumen = $recoleccion['volumen'];
                                            $cantidad = $recoleccion['cantidad'];
                                            if ($tipoTransporte == "contenedor") {
                                                $contenedor = $em->getRepository('ModelBundle:Contenedor')->find($idTipoTransporte);
                                                $newTransporte = new \ModelBundle\Entity\RecoleccionContenedor();
                                                $newTransporte->setContenedor($contenedor);
                                                $newTransporte->setRecoleccion($newRecoleccion);
                                                $newTransporte->setVolumen($this->formatFloat($volumen));
                                                $newTransporte->setCantidad($this->formatFloat($cantidad));
                                                $newRecoleccion->setRecoleccionContenedor($newTransporte);
                                                $em->persist($newTransporte);
                                            } elseif ($tipoTransporte == "volqueta") {
                                                $volqueta = $em->getRepository('ModelBundle:Volqueta')->find($idTipoTransporte);
                                                $newTransporte = new \ModelBundle\Entity\RecoleccionVolqueta();
                                                $newTransporte->setVolqueta($volqueta);
                                                $newTransporte->setRecoleccion($newRecoleccion);
                                                $newTransporte->setVolumen($this->formatFloat($volumen));
                                                $newTransporte->setCantidad($this->formatFloat($cantidad));
                                                $newRecoleccion->setRecoleccionVolqueta($newTransporte);
                                                $em->persist($newTransporte);
                                            }
                                            $em->persist($newRecoleccion);
                                        }
                                        if (array_key_exists('residuos', $recoleccion)) {
                                            foreach ($recoleccion['residuos'] as $residuo) {
                                                $residuo_recoleccion = new \ModelBundle\Entity\ResiduoRecoleccion();
                                                $residuoObject = $em->getRepository('ModelBundle:Residuo')->find($residuo['id']);
                                                if ($residuoObject) {
                                                    $residuo_recoleccion->setResiduo($residuoObject);
                                                    $residuo_recoleccion->setRecoleccion($newRecoleccion);
                                                    if (array_key_exists('densidad', $residuo) && ($residuo['densidad'] != "" || $residuo['densidad'] != null )) {
                                                        $residuo_recoleccion->setDensidad($this->formatFloat($residuo['densidad']));
                                                    }
                                                    $empresa_id = $residuo['empresa'];
                                                    $residuo_recoleccion->setEmpresaRecolectoraResiduos($em->getRepository('ModelBundle:EmpresaRecolectoraResiduos')->find($empresa_id));
                                                    $disposicion_id = $residuo['disposicion'];
                                                    $residuo_recoleccion->setDisposicion($em->getRepository('ModelBundle:Disposicion')->find($disposicion_id));
                                                    $residuo_recoleccion->setReciclabe($residuo['reciclable']);
                                                    $residuo_recoleccion->setPeso($this->formatFloat($residuo['peso']));
                                                    $residuo_recoleccion->setPrecio($this->formatFloat($residuo['precio']));
                                                    $em->persist($residuo_recoleccion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $em->flush();

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

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
        $tipos_residuos = $em->getRepository('ModelBundle:TipoResiduo')->findAllArray();
        $empresasRecolectoras = $em->getRepository('ModelBundle:EmpresaRecolectoraResiduos')->findAll();
        $usuariosKontrolGrun = $em->getRepository('ModelBundle:User')->findBy(array("es_kontrol_grun" => true));
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
                    'tipos_residuos' => $tipos_residuos,
                    "usuariosKontrolGrun" => $usuariosKontrolGrun,
                    "empresasRecolectoras" => $empresasRecolectoras
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

        $em = $this->getDoctrine()->getManager();
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
        $form = $this->createForm(new ProgramacionFormType($this->container), $object);
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $archivoSubidos = $this->get('request')->files->all();
                    $requestParams = $this->get('request')->request->all();
                    $user = $em->getRepository('ModelBundle:User')->find($this->get('request')->get('programacion_form')['gestor_ambiental']);
                    $object->setGestorAmbiental($user);
                    $object = $this->admin->update($object);
                    $archivosGuardados = array();
                    foreach ($object->getTiposResiduosTransporte() as $key => $tipo_residuo_transporte) {
                        $archivosGuardados[$key]['certificado'] = $tipo_residuo_transporte->getCertificadoDisposicion();
                        foreach ($tipo_residuo_transporte->getRecolecciones() as $key2 => $recoleccion) {
                            $archivosGuardados[$key][$key2] = $recoleccion->getManifiestoTransporte();
                            foreach ($recoleccion->getResiduos() as $residuo) {
                                $em->remove($residuo);
                            }
                            if ($recoleccion->getRecoleccionContenedor()) {
                                $remove = $recoleccion->getRecoleccionContenedor();
                                $em->remove($remove);
                            }
                            if ($recoleccion->getRecoleccionVolqueta()) {
                                $remove = $recoleccion->getRecoleccionVolqueta();
                                $em->remove($remove);
                            }
                            $em->remove($recoleccion);
                        }
                        $em->remove($tipo_residuo_transporte);
                    }
                    $em->flush();
                    $contadorTiposResiduos = 0;
                    foreach ($requestParams as $key => $value) {
                        if (strpos($key, 'tipo_residuo_') !== false) {
                            $tipo_residuo = $value;
                            $idTipo = $tipo_residuo['id'];
                            $tipoResiduo = $em->getRepository('ModelBundle:TipoResiduo')->find($idTipo);
                            if ($tipoResiduo) {
                                $tipo_residuo_transporte = new \ModelBundle\Entity\TipoResiduoTransporte();
                                $tipo_residuo_transporte->setProgramacion($object);
                                $tipo_residuo_transporte->setTipoResiduo($tipoResiduo);
                                if (
                                        array_key_exists($key, $archivoSubidos) &&
                                        array_key_exists('certificado', $archivoSubidos[$key]) &&
                                        $archivoSubidos[$key]['certificado']
                                ) {
                                    $tipo_residuo_transporte->uploadDisposicion($archivoSubidos[$key]['certificado']);
                                    $tipo_residuo_transporte->setValidado(true);
                                } elseif (array_key_exists($contadorTiposResiduos, $archivosGuardados) && $archivosGuardados[$contadorTiposResiduos]['certificado']) {

                                    $archivoConRuta = $archivosGuardados[$contadorTiposResiduos]['certificado'];
                                    $arregloRuta = explode("/uploads/certificado_disposicion/", $archivoConRuta);
                                    if ($arregloRuta > 0) {
                                        $tipo_residuo_transporte->setCertificadoDisposicion($arregloRuta[1]);
                                    }
                                    $tipo_residuo_transporte->setValidado(true);
                                } else {
                                    $tipo_residuo_transporte->setValidado(false);
                                }
                                $em->persist($tipo_residuo_transporte);
                                if (array_key_exists('recoleccion', $tipo_residuo)) {
                                    $recolecciones = $tipo_residuo['recoleccion'];
                                    foreach ($recolecciones as $keyR => $recoleccion) {
                                        $newRecoleccion = new \ModelBundle\Entity\Recoleccion();
                                        $newRecoleccion->setTipoResiduoTransporte($tipo_residuo_transporte);
                                        $fecha_programacion = $recoleccion['fecha_programacion'];
                                        $newRecoleccion->setFechaProgramacion(new \DateTime($fecha_programacion));
                                        $fecha_recoleccion = $recoleccion['fecha_recoleccion'];
                                        $newRecoleccion->setFechaRecoleccionEjecutada(new \DateTime($fecha_recoleccion));
                                        if (
                                                array_key_exists($key, $archivoSubidos) &&
                                                array_key_exists('recoleccion', $archivoSubidos[$key]) &&
                                                array_key_exists($keyR, $archivoSubidos[$key]['recoleccion']) &&
                                                $archivoSubidos[$key]['recoleccion'][$keyR]['manifiesto']
                                        ) {
                                            $newRecoleccion->uploadTransporte($archivoSubidos[$key]['recoleccion'][$keyR]['manifiesto']);
                                        } elseif (
                                                array_key_exists($contadorTiposResiduos, $archivosGuardados) &&
                                                array_key_exists($keyR, $archivosGuardados[$contadorTiposResiduos]) &&
                                                $archivosGuardados[$contadorTiposResiduos][$keyR]
                                        ) {
                                            $archivoConRuta = $archivosGuardados[$contadorTiposResiduos][$keyR];
                                            $arregloRuta = explode("/uploads/manifiesto_transporte/", $archivoConRuta);
                                            if ($arregloRuta > 0) {
                                                $newRecoleccion->setManifiestoTransporte($arregloRuta[1]);
                                            }
                                        }
                                        $em->persist($newRecoleccion);
                                        if (array_key_exists('tipo_transporte', $recoleccion) && $recoleccion["tipo_transporte"] != "personalizado") {
                                            $tipoTransporte = $recoleccion['tipo_transporte'];
                                            $idTipoTransporte = $recoleccion['id_tipo_transporte'];
                                            $volumen = $recoleccion['volumen'];
                                            $cantidad = $recoleccion['cantidad'];
                                            if ($tipoTransporte == "contenedor") {
                                                $contenedor = $em->getRepository('ModelBundle:Contenedor')->find($idTipoTransporte);
                                                $newTransporte = new \ModelBundle\Entity\RecoleccionContenedor();
                                                $newTransporte->setContenedor($contenedor);
                                                $newTransporte->setRecoleccion($newRecoleccion);
                                                $newTransporte->setVolumen($this->formatFloat($volumen));
                                                $newTransporte->setCantidad($this->formatFloat($cantidad));
                                                $newRecoleccion->setRecoleccionContenedor($newTransporte);
                                                $em->persist($newTransporte);
                                            } elseif ($tipoTransporte == "volqueta") {
                                                $volqueta = $em->getRepository('ModelBundle:Volqueta')->find($idTipoTransporte);
                                                $newTransporte = new \ModelBundle\Entity\RecoleccionVolqueta();
                                                $newTransporte->setVolqueta($volqueta);
                                                $newTransporte->setRecoleccion($newRecoleccion);
                                                $newTransporte->setVolumen($this->formatFloat($volumen));
                                                $newTransporte->setCantidad($this->formatFloat($cantidad));
                                                $newRecoleccion->setRecoleccionVolqueta($newTransporte);
                                                $em->persist($newTransporte);
                                            }
                                            $em->persist($newRecoleccion);
                                        }
                                        if (array_key_exists('residuos', $recoleccion)) {
                                            foreach ($recoleccion['residuos'] as $residuo) {
                                                $residuo_recoleccion = new \ModelBundle\Entity\ResiduoRecoleccion();
                                                $residuoObject = $em->getRepository('ModelBundle:Residuo')->find($residuo['id']);
                                                if ($residuoObject) {
                                                    $residuo_recoleccion->setResiduo($residuoObject);
                                                    $residuo_recoleccion->setRecoleccion($newRecoleccion);
                                                    if (array_key_exists('densidad', $residuo) && ($residuo['densidad'] != "" || $residuo['densidad'] != null )) {
                                                        $residuo_recoleccion->setDensidad($this->formatFloat($residuo['densidad']));
                                                    }
                                                    $empresa_id = $residuo['empresa'];
                                                    $residuo_recoleccion->setEmpresaRecolectoraResiduos($em->getRepository('ModelBundle:EmpresaRecolectoraResiduos')->find($empresa_id));
                                                    $disposicion_id = $residuo['disposicion'];
                                                    $residuo_recoleccion->setDisposicion($em->getRepository('ModelBundle:Disposicion')->find($disposicion_id));
                                                    $residuo_recoleccion->setReciclabe($residuo['reciclable']);
                                                    $residuo_recoleccion->setPeso($this->formatFloat($residuo['peso']));
                                                    $residuo_recoleccion->setPrecio($this->formatFloat($residuo['precio']));
                                                    $em->persist($residuo_recoleccion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $contadorTiposResiduos++;
                        }
                    }
                    $em->persist($object);
                    $em->flush();
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_edit_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

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
        $tipos_residuos = $em->getRepository('ModelBundle:TipoResiduo')->findAllArray();
        $empresasRecolectoras = $em->getRepository('ModelBundle:EmpresaRecolectoraResiduos')->findAll();
        $usuariosKontrolGrun = $em->getRepository('ModelBundle:User')->findBy(array("es_kontrol_grun" => true));
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'edit',
                    'form' => $view,
                    'object' => $object,
                    'tipos_residuos' => $tipos_residuos,
                    "usuariosKontrolGrun" => $usuariosKontrolGrun,
                    "empresasRecolectoras" => $empresasRecolectoras
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
    public function copiaAction($id = null) {
        // the key used to lookup the template
        $templateKey = 'edit';

        $em = $this->getDoctrine()->getManager();
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        $this->admin->setSubject($object);
        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new ProgramacionFormType($this->container), $object);
        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $archivoSubidos = $this->get('request')->files->all();
                    $requestParams = $this->get('request')->request->all();
                    $object = new \ModelBundle\Entity\Programacion();
                    $object->setCentroRecoleccion($form->get('centro_recoleccion')->getData());
                    $user = $em->getRepository('ModelBundle:User')->find($this->get('request')->get('programacion_form')['gestor_ambiental']);
                    $object->setGestorAmbiental($user);
                    $object->setObservacion($form->get('observacion')->getData());
                    $object->setPesadoEnCentroRecoleccion($form->get('pesado_en_centro_recoleccion')->getData());
                    foreach ($requestParams as $key => $value) {
                        if (strpos($key, 'tipo_residuo_') !== false) {
                            $tipo_residuo = $value;
                            $idTipo = $tipo_residuo['id'];
                            $tipoResiduo = $em->getRepository('ModelBundle:TipoResiduo')->find($idTipo);
                            if ($tipoResiduo) {
                                $tipo_residuo_transporte = new \ModelBundle\Entity\TipoResiduoTransporte();
                                $tipo_residuo_transporte->setProgramacion($object);
                                $tipo_residuo_transporte->setTipoResiduo($tipoResiduo);
                                if (
                                        array_key_exists($key, $archivoSubidos) &&
                                        array_key_exists('certificado', $archivoSubidos[$key]) &&
                                        $archivoSubidos[$key]['certificado']
                                ) {
                                    $tipo_residuo_transporte->uploadDisposicion($archivoSubidos[$key]['certificado']);
                                    $tipo_residuo_transporte->setValidado(true);
                                } else {
                                    $tipo_residuo_transporte->setValidado(false);
                                }
                                $em->persist($tipo_residuo_transporte);
                                if (array_key_exists('recoleccion', $tipo_residuo)) {
                                    $recolecciones = $tipo_residuo['recoleccion'];
                                    foreach ($recolecciones as $keyR => $recoleccion) {
                                        $newRecoleccion = new \ModelBundle\Entity\Recoleccion();
                                        $newRecoleccion->setTipoResiduoTransporte($tipo_residuo_transporte);
                                        $fecha_programacion = $recoleccion['fecha_programacion'];
                                        $newRecoleccion->setFechaProgramacion(new \DateTime($fecha_programacion));
                                        $fecha_recoleccion = $recoleccion['fecha_recoleccion'];
                                        $newRecoleccion->setFechaRecoleccionEjecutada(new \DateTime($fecha_recoleccion));
                                        if (
                                                array_key_exists($key, $archivoSubidos) &&
                                                array_key_exists('recoleccion', $archivoSubidos[$key]) &&
                                                array_key_exists($keyR, $archivoSubidos[$key]['recoleccion']) &&
                                                $archivoSubidos[$key]['recoleccion'][$keyR]['manifiesto']
                                        ) {
                                            $newRecoleccion->uploadTransporte($archivoSubidos[$key]['recoleccion'][$keyR]['manifiesto']);
                                        }
                                        $em->persist($newRecoleccion);
                                        if (array_key_exists('tipo_transporte', $recoleccion) && $recoleccion["tipo_transporte"] != "personalizado") {
                                            $tipoTransporte = $recoleccion['tipo_transporte'];
                                            $idTipoTransporte = $recoleccion['id_tipo_transporte'];
                                            $volumen = $recoleccion['volumen'];
                                            $cantidad = $recoleccion['cantidad'];
                                            if ($tipoTransporte == "contenedor") {
                                                $contenedor = $em->getRepository('ModelBundle:Contenedor')->find($idTipoTransporte);
                                                $newTransporte = new \ModelBundle\Entity\RecoleccionContenedor();
                                                $newTransporte->setContenedor($contenedor);
                                                $newTransporte->setRecoleccion($newRecoleccion);
                                                $newTransporte->setVolumen($this->formatFloat($volumen));
                                                $newTransporte->setCantidad($this->formatFloat($cantidad));
                                                $newRecoleccion->setRecoleccionContenedor($newTransporte);
                                                $em->persist($newTransporte);
                                            } elseif ($tipoTransporte == "volqueta") {
                                                $volqueta = $em->getRepository('ModelBundle:Volqueta')->find($idTipoTransporte);
                                                $newTransporte = new \ModelBundle\Entity\RecoleccionVolqueta();
                                                $newTransporte->setVolqueta($volqueta);
                                                $newTransporte->setRecoleccion($newRecoleccion);
                                                $newTransporte->setVolumen($this->formatFloat($volumen));
                                                $newTransporte->setCantidad($this->formatFloat($cantidad));
                                                $newRecoleccion->setRecoleccionVolqueta($newTransporte);
                                                $em->persist($newTransporte);
                                            }
                                            $em->persist($newRecoleccion);
                                        }
                                        if (array_key_exists('residuos', $recoleccion)) {
                                            foreach ($recoleccion['residuos'] as $residuo) {
                                                $residuo_recoleccion = new \ModelBundle\Entity\ResiduoRecoleccion();
                                                $residuoObject = $em->getRepository('ModelBundle:Residuo')->find($residuo['id']);
                                                if ($residuoObject) {
                                                    $residuo_recoleccion->setResiduo($residuoObject);
                                                    $residuo_recoleccion->setRecoleccion($newRecoleccion);
                                                    if (array_key_exists('densidad', $residuo) && ($residuo['densidad'] != "" || $residuo['densidad'] != null )) {
                                                        $residuo_recoleccion->setDensidad($this->formatFloat($residuo['densidad']));
                                                    }
                                                    $empresa_id = $residuo['empresa'];
                                                    $residuo_recoleccion->setEmpresaRecolectoraResiduos($em->getRepository('ModelBundle:EmpresaRecolectoraResiduos')->find($empresa_id));
                                                    $disposicion_id = $residuo['disposicion'];
                                                    $residuo_recoleccion->setDisposicion($em->getRepository('ModelBundle:Disposicion')->find($disposicion_id));
                                                    $residuo_recoleccion->setReciclabe($residuo['reciclable']);
                                                    $residuo_recoleccion->setPeso($this->formatFloat($residuo['peso']));
                                                    $residuo_recoleccion->setPrecio($this->formatFloat($residuo['precio']));
                                                    $em->persist($residuo_recoleccion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $em->persist($object);
                    $em->flush($object);
                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                                    'result' => 'ok',
                                    'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                            'sonata_flash_success', $this->admin->trans(
                                    'flash_create_success', array('%name%' => $this->escapeHtml($this->admin->toString($object))), 'SonataAdminBundle'
                            )
                    );

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
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());
        $tipos_residuos = $em->getRepository('ModelBundle:TipoResiduo')->findAllArray();
        $empresasRecolectoras = $em->getRepository('ModelBundle:EmpresaRecolectoraResiduos')->findAll();
        $usuariosKontrolGrun = $em->getRepository('ModelBundle:User')->findBy(array("es_kontrol_grun" => true));
        return $this->render($this->admin->getTemplate($templateKey), array(
                    'action' => 'create',
                    'form' => $view,
                    'object' => $object,
                    'copia' => true,
                    'tipos_residuos' => $tipos_residuos,
                    "usuariosKontrolGrun" => $usuariosKontrolGrun,
                    "empresasRecolectoras" => $empresasRecolectoras
        ));
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

    public function formatFloat($number) {
        return str_replace(",", ".", str_replace(".", "", $number));
    }

    protected function getJpgOptions() {
        return ['width' => 2480, 'height' => 3508];
    }

    protected function getPdfOptions() {
//        return ['orientation' => 'landscape'];
        return [];
    }

}
