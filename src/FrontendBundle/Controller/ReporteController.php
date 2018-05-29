<?php

namespace FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BackendBundle\Form\Type\RDetalladoTiposFormType;
use BackendBundle\Form\Type\RDetalladoTotalTiposFormType;
use BackendBundle\Form\Type\RDetalladoGestorFormType;
use BackendBundle\Form\Type\RDetalladoAprovechablesFormType;
use BackendBundle\Form\Type\RDetalladoEconomicoFormType;
use BackendBundle\Form\Type\RDetalladoFechasFormType;
use BackendBundle\Form\Type\RChecklistFormType;
use BackendBundle\Form\Type\RResiduosDisposicionFormType;
use BackendBundle\Form\Type\ROperativoFormType;
use BackendBundle\Form\Type\RCapacitacionesFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;

class ReporteController extends Controller {

    /**
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function detalladoAction(Request $request) {

        /** @var $form \Symfony\Component\Form\Form */
        $container = $this->container;
        $formTipos = $this->createForm(new RDetalladoTiposFormType($container));
        $formTotalTipos = $this->createForm(new RDetalladoTotalTiposFormType($container));
        $formGestor = $this->createForm(new RDetalladoGestorFormType($container));
        $formAprovechables = $this->createForm(new RDetalladoAprovechablesFormType($container));
        $formFechas = $this->createForm(new RDetalladoFechasFormType($container));


        if ($request->getRealMethod() == 'POST') {
            if ($this->getRequest()->request->has('r_detallado_tipos_form')) {

                $formTipos->submit($this->get('request'));

                $isFormValid = $formTipos->isValid();
                if ($isFormValid) {
                    try {
                        $nombre_grafica = "tipos_residuos";
                        $datos = $this->dataReporteDetalladoTipos($formTipos);
                        $titulo = $datos['titulo'];
                        if ($request->isXmlHttpRequest()) {
                            return $this->render("FrontendBundle:Reportes:Detallado/Tipos/template_grafica.html.twig", array(
                                        'nombre_grafica' => $nombre_grafica,
                                        'datos' => $datos['series'],
                                        'titulo' => $titulo,
                            ));
                        } else {
                            $base64 = $formTipos->get('imagen_grafica')->getData();
                            if ($this->get('request')->get('pdf')) {
                                $html = $this->renderView("FrontendBundle:Reportes:Detallado/Tipos/template_grafica_pdf.html.twig", array(
                                    'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'graficaBase64' => $base64
                                ));
                                return new Response(
                                        $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                            'orientation' => 'Landscape',
                                            'margin-left' => 15,
                                            'footer-html' => $this->getFooter(),
                                            'images' => true,
                                            'enable-javascript' => true
                                        )), 200, array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="Reporte residuos.pdf"'
                                        )
                                );
                            } elseif ($this->get('request')->get('excel')) {
                                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                                $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                                $nombreTemporal = md5(uniqid()) . "png";
                                file_put_contents($ruta_temp . $nombreTemporal, $data);
                                $imagenGrafica = $ruta_temp . $nombreTemporal;
                                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                                $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                                $phpExcelObject->getActiveSheet()->setTitle("Reporte residuos");
                                $activeSheet->getDefaultColumnDimension()->setWidth(20);
                                $activeSheet
                                        ->setCellValue('B1', $datos['titulo'])
                                        ->setCellValue('A3', 'Tipo de residuo')
                                        ->setCellValue('B3', 'Peso en Kg');
                                $activeSheet->mergeCells('B1:F1');
                                $fila = 4;
                                foreach ($datos['series'] as $tipoResiduo) {
                                    $activeSheet->setCellValue('A' . $fila, $tipoResiduo['nombre']);
                                    $peso = number_format($tipoResiduo['peso'], 3, ',', '.');
                                    $activeSheet->setCellValue('B' . $fila, $peso);
                                    $fila++;
                                }
                                $objDrawing = new \PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('Grafica');
                                $objDrawing->setDescription('Grafica');
                                $objDrawing->setPath($imagenGrafica);
                                $objDrawing->setCoordinates('D2');
                                $objDrawing->setWorksheet($activeSheet);

                                // create the writer
                                $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                                $response = $this->get('phpexcel')->createStreamedResponse($writer);
                                // adding headers
                                $dispositionHeader = $response->headers->makeDisposition(
                                        ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte residuos.xls'
                                );
                                $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                                $response->headers->set('Pragma', 'public');
                                $response->headers->set('Cache-Control', 'maxage=1');
                                $response->headers->set('Content-Disposition', $dispositionHeader);
                                return $response;
                            }
                        }
                    } catch (ModelManagerException $e) {
                        $this->logModelManagerException($e);
                        $isFormValid = false;
                    }
                }
            }
            if ($this->getRequest()->request->has('r_detallado_total_tipos_form')) {

                $formTotalTipos->submit($this->get('request'));

                $isFormValid = $formTotalTipos->isValid();
                if ($isFormValid) {

                    try {
                        $nombre_grafica = "total_tipos_residuos";
                        $datos = $this->dataReporteOperativo($formTotalTipos);
                        $titulo = $datos['titulo'];
                        if ($request->isXmlHttpRequest()) {
                            return $this->render("FrontendBundle:Reportes:Detallado/TotalTipos/template_grafica.html.twig", array(
                                        'nombre_grafica' => $nombre_grafica,
                                        'datos' => $datos['series'],
                                        'titulo' => $titulo,
                            ));
                        } else {
                            $base64 = $formTotalTipos->get('imagen_grafica')->getData();
                            if ($this->get('request')->get('pdf')) {
                                $html = $this->renderView("FrontendBundle:Reportes:Detallado/TotalTipos/template_grafica_pdf.html.twig", array(
                                    'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'graficaBase64' => $base64
                                ));
                                return new Response(
                                        $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                            'orientation' => 'Landscape',
                                            'margin-left' => 15,
                                            'footer-html' => $this->getFooter(),
                                            'images' => true,
                                            'enable-javascript' => true
                                        )), 200, array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="Reporte total tipos de residuos.pdf"'
                                        )
                                );
                            } elseif ($this->get('request')->get('excel')) {
                                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                                $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                                $nombreTemporal = md5(uniqid()) . "png";
                                file_put_contents($ruta_temp . $nombreTemporal, $data);
                                $imagenGrafica = $ruta_temp . $nombreTemporal;
                                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                                $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                                $phpExcelObject->getActiveSheet()->setTitle("Reporte total tipos de residuos");
                                $activeSheet->getDefaultColumnDimension()->setWidth(20);
                                $activeSheet
                                        ->setCellValue('B1', $datos['titulo'])
                                        ->setCellValue('A3', 'Tipo de residuo')
                                        ->setCellValue('B3', 'Peso en Kg')
                                        ->setCellValue('C3', 'Porcentaje %');
                                $activeSheet->mergeCells('B1:F1');
                                $fila = 4;
                                $totalPeso = 0;
                                foreach ($datos['series'] as $tipoResiduo) {
                                    $totalPeso += $tipoResiduo['peso'];
                                }
                                foreach ($datos['series'] as $tipoResiduo) {
                                    $activeSheet->setCellValue('A' . $fila, $tipoResiduo['nombre']);
                                    $peso = number_format($tipoResiduo['peso'], 3, ',', '.');
                                    $activeSheet->setCellValue('B' . $fila, $peso);
                                    $porcentaje = number_format(round(($tipoResiduo['peso'] * 100 / $totalPeso), 1), 1, ',', '.');
                                    $activeSheet->setCellValue('C' . $fila, $porcentaje);
                                    $fila++;
                                }
                                $objDrawing = new \PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('Grafica');
                                $objDrawing->setDescription('Grafica');
                                $objDrawing->setPath($imagenGrafica);
                                $objDrawing->setCoordinates('D2');
                                $objDrawing->setWorksheet($activeSheet);

                                // create the writer
                                $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                                $response = $this->get('phpexcel')->createStreamedResponse($writer);
                                // adding headers
                                $dispositionHeader = $response->headers->makeDisposition(
                                        ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte total tipos de residuos.xls'
                                );
                                $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                                $response->headers->set('Pragma', 'public');
                                $response->headers->set('Cache-Control', 'maxage=1');
                                $response->headers->set('Content-Disposition', $dispositionHeader);
                                return $response;
                            }
                        }
                    } catch (ModelManagerException $e) {
                        $this->logModelManagerException($e);
                        $isFormValid = false;
                    }
                }
            }
            if ($this->getRequest()->request->has('r_detallado_gestor_form')) {

                $formGestor->submit($this->get('request'));

                $isFormValid = $formGestor->isValid();
                if ($isFormValid) {

                    try {
                        $nombre_grafica = "gestor_residuos";
                        $datos = $this->dataReporteDetalladoGestor($formGestor);
                        $titulo = $datos['titulo'];
                        if ($request->isXmlHttpRequest()) {
                            return $this->render("FrontendBundle:Reportes:Detallado/Gestor/template_grafica.html.twig", array(
                                        'nombre_grafica' => $nombre_grafica,
                                        'datos' => $datos['series'],
                                        'titulo' => $titulo,
                            ));
                        } else {
                            $base64 = $formGestor->get('imagen_grafica')->getData();
                            if ($this->get('request')->get('pdf')) {
                                $html = $this->renderView("FrontendBundle:Reportes:Detallado/Gestor/template_grafica_pdf.html.twig", array(
                                    'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'graficaBase64' => $base64
                                ));
                                return new Response(
                                        $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                            'orientation' => 'Landscape',
                                            'margin-left' => 15,
                                            'footer-html' => $this->getFooter(),
                                            'images' => true,
                                            'enable-javascript' => true
                                        )), 200, array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="Reporte gestor ambiental.pdf"'
                                        )
                                );
                            } elseif ($this->get('request')->get('excel')) {
                                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                                $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                                $nombreTemporal = md5(uniqid()) . "png";
                                file_put_contents($ruta_temp . $nombreTemporal, $data);
                                $imagenGrafica = $ruta_temp . $nombreTemporal;
                                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                                $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                                $phpExcelObject->getActiveSheet()->setTitle("Reporte gestor ambiental");
                                $activeSheet->getDefaultColumnDimension()->setWidth(20);
                                $activeSheet
                                        ->setCellValue('B1', $datos['titulo'])
                                        ->setCellValue('A3', 'Tipo de residuo')
                                        ->setCellValue('B3', 'Peso en Kg');
                                $activeSheet->mergeCells('B1:F1');
                                $fila = 4;
                                foreach ($datos['series'] as $tipoResiduo) {
                                    $activeSheet->setCellValue('A' . $fila, $tipoResiduo['nombre']);
                                    $peso = number_format($tipoResiduo['peso'], 3, ',', '.');
                                    $activeSheet->setCellValue('B' . $fila, $peso);
                                    $fila++;
                                }
                                $objDrawing = new \PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('Grafica');
                                $objDrawing->setDescription('Grafica');
                                $objDrawing->setPath($imagenGrafica);
                                $objDrawing->setCoordinates('D2');
                                $objDrawing->setWorksheet($activeSheet);

                                // create the writer
                                $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                                $response = $this->get('phpexcel')->createStreamedResponse($writer);
                                // adding headers
                                $dispositionHeader = $response->headers->makeDisposition(
                                        ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte gestor ambiental.xls'
                                );
                                $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                                $response->headers->set('Pragma', 'public');
                                $response->headers->set('Cache-Control', 'maxage=1');
                                $response->headers->set('Content-Disposition', $dispositionHeader);
                                return $response;
                            }
                        }
                    } catch (ModelManagerException $e) {
                        $this->logModelManagerException($e);
                        $isFormValid = false;
                    }
                }
            }
            if ($this->getRequest()->request->has('r_detallado_fechas_form')) {

                $formFechas->submit($this->get('request'));

                $isFormValid = $formFechas->isValid();
                if ($isFormValid) {
                    try {
                        $nombre_grafica = "tipos_residuos_fechas";
                        $datos = $this->dataReporteDetalladoFechas($formFechas);
                        $titulo = $datos['titulo'];
                        $tiposResiduos = $datos['tiposResiduos'];
                        if ($request->isXmlHttpRequest()) {
                            return $this->render("FrontendBundle:Reportes:Detallado/Mensual/template_grafica.html.twig", array(
                                        'nombre_grafica' => $nombre_grafica,
                                        'datos' => $datos['series'],
                                        'tiposResiduos' => $tiposResiduos,
                                        'titulo' => $titulo,
                            ));
                        } else {
                            $base64 = $formFechas->get('imagen_grafica')->getData();
                            if ($this->get('request')->get('pdf')) {
                                $html = $this->renderView("FrontendBundle:Reportes:Detallado/Mensual/template_grafica_pdf.html.twig", array(
                                    'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'graficaBase64' => $base64,
                                    'tiposResiduos' => $tiposResiduos,
                                ));
                                return new Response(
                                        $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                            'orientation' => 'Landscape',
                                            'margin-left' => 15,
                                            'footer-html' => $this->getFooter(),
                                            'images' => true,
                                            'enable-javascript' => true
                                        )), 200, array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="Reporte Mensual tipos de residuos.pdf"'
                                        )
                                );
                            } elseif ($this->get('request')->get('excel')) {
                                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                                $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                                $nombreTemporal = md5(uniqid()) . "png";
                                file_put_contents($ruta_temp . $nombreTemporal, $data);
                                $imagenGrafica = $ruta_temp . $nombreTemporal;
                                $phpExcelObject = new \PHPExcel();
                                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                                $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                                $phpExcelObject->getActiveSheet()->setTitle("Reporte tipos de residuos");
                                $activeSheet->getDefaultColumnDimension()->setWidth(15);
                                $activeSheet
                                        ->setCellValue('B1', $datos['titulo'])
                                        ->setCellValue('A3', 'Año-Mes/Tipo de residuo');
                                $activeSheet->mergeCells('B1:F1');
                                $columna = 'C';
                                foreach ($tiposResiduos as $tipoResiduo) {
                                    $activeSheet->setCellValue($columna . '3', $tipoResiduo->getNombre());
                                    $columna++;
                                }

                                $activeSheet->getColumnDimension('A')->setWidth(30);
                                $fila = 4;
                                foreach ($datos['series'] as $fecha => $tipos) {
                                    $activeSheet->setCellValue('A' . $fila, $fecha);
                                    $columna = "B";
                                    foreach ($tipos as $tipo) {
                                        $peso = number_format($tipo['peso'], 3, ',', '.');
                                        $activeSheet->setCellValue($columna . $fila, $peso);
                                        $columna++;
                                    }
                                    $fila++;
                                }
                                $objDrawing = new \PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('Grafica');
                                $objDrawing->setDescription('Grafica');
                                $objDrawing->setPath($imagenGrafica);
                                $objDrawing->setCoordinates('J2');
                                $objDrawing->setWorksheet($activeSheet);

                                // create the writer
                                $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                                $response = $this->get('phpexcel')->createStreamedResponse($writer);
                                // adding headers
                                $dispositionHeader = $response->headers->makeDisposition(
                                        ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte Mensual tipos de residuos.xls'
                                );
                                $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                                $response->headers->set('Pragma', 'public');
                                $response->headers->set('Cache-Control', 'maxage=1');
                                $response->headers->set('Content-Disposition', $dispositionHeader);
                                return $response;
                            }
                        }
                    } catch (ModelManagerException $e) {
                        $this->logModelManagerException($e);
                        $isFormValid = false;
                    }
                }
            }
            if ($this->getRequest()->request->has('r_detallado_aprovechables_form')) {

                $formAprovechables->submit($this->get('request'));

                $isFormValid = $formAprovechables->isValid();
                if ($isFormValid) {

                    try {
                        $nombre_grafica = "residuos_aprovechables";
                        $datos = $this->dataReporteDetalladoAprovechables($formAprovechables);
                        $titulo = $datos['titulo'];
                        if ($request->isXmlHttpRequest()) {
                            return $this->render("FrontendBundle:Reportes:Detallado/Aprovechables/template_grafica.html.twig", array(
                                        'nombre_grafica' => $nombre_grafica,
                                        'datos' => $datos['series'],
                                        'titulo' => $titulo,
                            ));
                        } else {
                            $base64 = $formAprovechables->get('imagen_grafica')->getData();
                            if ($this->get('request')->get('pdf')) {
                                $html = $this->renderView("FrontendBundle:Reportes:Detallado/Aprovechables/template_grafica_pdf.html.twig", array(
                                    'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'graficaBase64' => $base64
                                ));
                                return new Response(
                                        $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                            'orientation' => 'Landscape',
                                            'margin-left' => 15,
                                            'footer-html' => $this->getFooter(),
                                            'images' => true,
                                            'enable-javascript' => true
                                        )), 200, array(
                                    'Content-Type' => 'application/pdf',
                                    'Content-Disposition' => 'attachment; filename="Reporte residuos aprovechables.pdf"'
                                        )
                                );
                            } elseif ($this->get('request')->get('excel')) {
                                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                                $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                                $nombreTemporal = md5(uniqid()) . "png";
                                file_put_contents($ruta_temp . $nombreTemporal, $data);
                                $imagenGrafica = $ruta_temp . $nombreTemporal;
                                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                                $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                                $phpExcelObject->getActiveSheet()->setTitle("Reporte residuos aprovechables");
                                $activeSheet->getDefaultColumnDimension()->setWidth(20);
                                $activeSheet
                                        ->setCellValue('B1', $datos['titulo'])
                                        ->setCellValue('A3', 'Tipo de residuo')
                                        ->setCellValue('B3', 'Peso en Kg');
                                $activeSheet->mergeCells('B1:F1');
                                $fila = 4;
                                foreach ($datos['series'][0] as $tipoResiduo => $peso) {
                                    $activeSheet->setCellValue('A' . $fila, $tipoResiduo);
                                    $peso = number_format($peso, 3, ',', '.');
                                    $activeSheet->setCellValue('B' . $fila, $peso);
                                    $fila++;
                                }
                                $objDrawing = new \PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('Grafica');
                                $objDrawing->setDescription('Grafica');
                                $objDrawing->setPath($imagenGrafica);
                                $objDrawing->setCoordinates('D2');
                                $objDrawing->setWorksheet($activeSheet);

                                // create the writer
                                $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                                $response = $this->get('phpexcel')->createStreamedResponse($writer);
                                // adding headers
                                $dispositionHeader = $response->headers->makeDisposition(
                                        ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte residuos aprovechables.xls'
                                );
                                $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                                $response->headers->set('Pragma', 'public');
                                $response->headers->set('Cache-Control', 'maxage=1');
                                $response->headers->set('Content-Disposition', $dispositionHeader);
                                return $response;
                            }
                        }
                    } catch (ModelManagerException $e) {
                        $this->logModelManagerException($e);
                        $isFormValid = false;
                    }
                }
            }
        }
        $viewTipos = $formTipos->createView();
        $viewTotalTipos = $formTotalTipos->createView();
        $viewGestor = $formGestor->createView();
        $viewAprovechables = $formAprovechables->createView();
        $viewFechas = $formFechas->createView();
        $em = $this->getDoctrine()->getManager();
        $gestores = null;
        if ($this->getUser() && $this->getUser()->getCliente()) {
            $gestores = $em->getRepository('ModelBundle:User')->findBy(array("cliente" => $this->getUser()->getCliente()));
        }
        return $this->render("FrontendBundle:Reportes/Detallado:base_edit.html.twig", array(
                    'formTipos' => $viewTipos,
                    'formTotalTipos' => $viewTotalTipos,
                    'formGestor' => $viewGestor,
                    'formFechas' => $viewFechas,
                    'formAprovechables' => $viewAprovechables,
                    'gestores' => $gestores,
                    'ruta' => 'informes'
        ));
    }

    public function operativoAction(Request $request) {


        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new ROperativoFormType($this->container));

        if ($request->getMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();
            if ($isFormValid) {
                try {
                    $nombre_grafica = "operativo";
                    $datos = $this->dataReporteOperativo($form);
                    $titulo = $datos['titulo'];
                    if ($request->isXmlHttpRequest()) {
                        return $this->render("FrontendBundle:Reportes:Operativo/template_grafica.html.twig", array(
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'titulo' => $titulo,
                        ));
                    } else {
                        $base64 = $form->get('imagen_grafica')->getData();
                        if ($this->get('request')->get('pdf')) {
                            $html = $this->renderView("FrontendBundle:Reportes:Operativo/template_grafica_pdf.html.twig", array(
                                'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                'nombre_grafica' => $nombre_grafica,
                                'datos' => $datos['series'],
                                'graficaBase64' => $base64
                            ));
                            return new Response(
                                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                        'orientation' => 'Landscape',
                                        'margin-left' => 15,
                                        'footer-html' => $this->getFooter(),
                                        'images' => true,
                                        'enable-javascript' => true
                                    )), 200, array(
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="Reporte operativo.pdf"'
                                    )
                            );
                        } elseif ($this->get('request')->get('excel')) {
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                            $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                            $nombreTemporal = md5(uniqid()) . "png";
                            file_put_contents($ruta_temp . $nombreTemporal, $data);
                            $imagenGrafica = $ruta_temp . $nombreTemporal;
                            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                            $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                            $phpExcelObject->getActiveSheet()->setTitle("Reporte operativo");
                            $activeSheet->getDefaultColumnDimension()->setWidth(20);
                            $activeSheet
                                    ->setCellValue('B1', $datos['titulo'])
                                    ->setCellValue('A3', 'Tipo de residuo')
                                    ->setCellValue('B3', 'Peso en Kg');
                            $activeSheet->mergeCells('B1:F1');
                            $fila = 4;
                            foreach ($datos['series'] as $tipoResiduo) {
                                $activeSheet->setCellValue('A' . $fila, $tipoResiduo['nombre']);
                                $peso = number_format($tipoResiduo['peso'], 3, ',', '.');
                                $activeSheet->setCellValue('B' . $fila, $peso);
                                $fila++;
                            }
                            $objDrawing = new \PHPExcel_Worksheet_Drawing();
                            $objDrawing->setName('Grafica');
                            $objDrawing->setDescription('Grafica');
                            $objDrawing->setPath($imagenGrafica);
                            $objDrawing->setCoordinates('D2');
                            $objDrawing->setWorksheet($activeSheet);

                            // create the writer
                            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                            $response = $this->get('phpexcel')->createStreamedResponse($writer);
                            // adding headers
                            $dispositionHeader = $response->headers->makeDisposition(
                                    ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte operativo.xls'
                            );
                            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                            $response->headers->set('Pragma', 'public');
                            $response->headers->set('Cache-Control', 'maxage=1');
                            $response->headers->set('Content-Disposition', $dispositionHeader);
                            return $response;
                        }
                    }
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);
                    $isFormValid = false;
                }
            }
        }
        $view = $form->createView();
        return $this->render("FrontendBundle:Reportes:Operativo/base_edit.html.twig", array(
                    'action' => 'create',
                    'form' => $view,
                    'ruta' => 'informes'
        ));
    }

    public function residuosDisposicionAction(Request $request) {

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new RResiduosDisposicionFormType($this->container));

        if ($request->getMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();
            if ($isFormValid) {
                try {
                    $nombre_grafica = "disposiciones";
                    $datos = $this->dataReporteResiduosDisposicion($form);
                    $titulo = $datos['titulo'];
                    if ($request->isXmlHttpRequest()) {
                        return $this->render("FrontendBundle:Reportes:ResiduosDisposicion/template_grafica.html.twig", array(
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'titulo' => $titulo,
                        ));
                    } else {
                        $base64 = $form->get('imagen_grafica')->getData();
                        if ($this->get('request')->get('pdf')) {
                            $html = $this->renderView("FrontendBundle:Reportes:ResiduosDisposicion/template_grafica_pdf.html.twig", array(
                                'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                'nombre_grafica' => $nombre_grafica,
                                'datos' => $datos['series'],
                                'graficaBase64' => $base64
                            ));
                            return new Response(
                                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                        'orientation' => 'Landscape',
                                        'margin-left' => 15,
                                        'footer-html' => $this->getFooter(),
                                        'images' => true,
                                        'enable-javascript' => true
                                    )), 200, array(
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="Reporte disposiciones.pdf"'
                                    )
                            );
                        } elseif ($this->get('request')->get('excel')) {
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                            $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                            $nombreTemporal = md5(uniqid()) . "png";
                            file_put_contents($ruta_temp . $nombreTemporal, $data);
                            $imagenGrafica = $ruta_temp . $nombreTemporal;
                            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                            $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                            $phpExcelObject->getActiveSheet()->setTitle("Reporte disposiciones");
                            $activeSheet->getDefaultColumnDimension()->setWidth(20);
                            $activeSheet
                                    ->setCellValue('B1', $datos['titulo'])
                                    ->setCellValue('A3', 'Disposición')
                                    ->setCellValue('B3', '# de veces utilizada')
                                    ->setCellValue('C3', 'Porcentaje %');
                            $activeSheet->mergeCells('B1:F1');
                            $fila = 4;
                            $totalPeso = 0;
                            foreach ($datos['series'] as $disposicion) {
                                $totalPeso += $disposicion['cantidad'];
                            }
                            foreach ($datos['series'] as $disposicion) {
                                $activeSheet->setCellValue('A' . $fila, $disposicion['nombre']);
                                $activeSheet->setCellValue('B' . $fila, $disposicion['cantidad']);
                                $porcentaje = round(($disposicion['cantidad'] * 100 / $totalPeso), 1);
                                $activeSheet->setCellValue('C' . $fila, $porcentaje);
                                $fila++;
                            }
                            $objDrawing = new \PHPExcel_Worksheet_Drawing();
                            $objDrawing->setName('Grafica');
                            $objDrawing->setDescription('Grafica');
                            $objDrawing->setPath($imagenGrafica);
                            $objDrawing->setCoordinates('D2');
                            $objDrawing->setWorksheet($activeSheet);

                            // create the writer
                            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                            $response = $this->get('phpexcel')->createStreamedResponse($writer);
                            // adding headers
                            $dispositionHeader = $response->headers->makeDisposition(
                                    ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte disposiciones.xls'
                            );
                            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                            $response->headers->set('Pragma', 'public');
                            $response->headers->set('Cache-Control', 'maxage=1');
                            $response->headers->set('Content-Disposition', $dispositionHeader);
                            return $response;
                        }
                    }
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);
                    $isFormValid = false;
                }
            }
        }
        $view = $form->createView();
        return $this->render("FrontendBundle:Reportes:ResiduosDisposicion/base_edit.html.twig", array(
                    'action' => 'create',
                    'form' => $view,
                    'ruta' => 'informes'
        ));
    }

    public function checklistAction(Request $request) {
        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new RChecklistFormType($this->container));

        if ($request->getMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();
            if ($isFormValid) {
                try {
                    $nombre_grafica = "checklist";
                    $datosCumplen = $this->dataReporteChecklist($form, 1);
                    $datosNoCumplen = $this->dataReporteChecklist($form, 0);
                    $titulo = $datosCumplen['titulo'];
                    if ($request->isXmlHttpRequest()) {
                        return $this->render("FrontendBundle:Reportes:Checklist/template_grafica.html.twig", array(
                                    'nombre_grafica' => $nombre_grafica,
                                    'cumplen' => $datosCumplen['series'],
                                    'noCumplen' => $datosNoCumplen['series'],
                                    'titulo' => $titulo,
                        ));
                    } else {
                        $base64 = $form->get('imagen_grafica')->getData();
                        if ($this->get('request')->get('pdf')) {
                            $html = $this->renderView("FrontendBundle:Reportes:Checklist/template_grafica_pdf.html.twig", array(
                                'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                'nombre_grafica' => $nombre_grafica,
                                'cumplen' => $datosCumplen['series'],
                                'noCumplen' => $datosNoCumplen['series'],
                                'graficaBase64' => $base64
                            ));
                            return new Response(
                                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                        'orientation' => 'Landscape',
                                        'margin-left' => 15,
                                        'footer-html' => $this->getFooter(),
                                        'images' => true,
                                        'enable-javascript' => true
                                    )), 200, array(
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="Reporte PMIRS.pdf"'
                                    )
                            );
                        } elseif ($this->get('request')->get('excel')) {
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                            $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                            $nombreTemporal = md5(uniqid()) . "png";
                            file_put_contents($ruta_temp . $nombreTemporal, $data);
                            $imagenGrafica = $ruta_temp . $nombreTemporal;
                            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                            $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                            $phpExcelObject->getActiveSheet()->setTitle("Reporte operativo");
                            $activeSheet->getDefaultColumnDimension()->setWidth(20);
                            $activeSheet
                                    ->setCellValue('B1', $titulo)
                                    ->setCellValue('A2', 'Cumplen: ' . count($datosCumplen['series']))
                                    ->setCellValue('A3', 'Cliente')
                                    ->setCellValue('B3', 'Centro de costo')
                                    ->setCellValue('C3', 'Fecha ejecutada')
                                    ->setCellValue('D3', 'Archivo');
                            $activeSheet->mergeCells('B1:F1');
                            $activeSheet->mergeCells('A2:B2');
                            $activeSheet
                                    ->setCellValue('F2', 'No Cumplen: ' . count($datosNoCumplen['series']))
                                    ->setCellValue('F3', 'Cliente')
                                    ->setCellValue('G3', 'Centro de costo')
                                    ->setCellValue('H3', 'Fecha ejecutada')
                                    ->setCellValue('I3', 'Archivo');
                            $activeSheet->mergeCells('B1:F1');
                            $activeSheet->mergeCells('F2:I2');
                            $activeSheet->mergeCells('A2:D2');
                            $fila = 4;
                            foreach ($datosCumplen['series'] as $seguimiento) {
                                $activeSheet->setCellValue('A' . $fila, $seguimiento->getCentroRecoleccion()->getCliente()->getNombre());
                                $activeSheet->setCellValue('B' . $fila, $seguimiento->getCentroRecoleccion()->getNombre());
                                $activeSheet->setCellValue('C' . $fila, $seguimiento->getFechaEjecucion()->format('d-m-Y'));
                                if ($seguimiento->getArchivoEncuesta()) {
                                    $url = $this->getRequest()->getSchemeAndHttpHost() . $seguimiento->getArchivoEncuesta();
                                    $activeSheet->setCellValue('D' . $fila, 'Ver Archivo');
                                    $activeSheet->getCell('D' . $fila)->getHyperlink()->setUrl($url);
                                    $link_style_array = [
                                        'font' => [
                                            'color' => ['rgb' => '0000FF'],
                                            'underline' => 'single'
                                        ]
                                    ];
                                    $activeSheet->getStyle("D" . $fila)->applyFromArray($link_style_array);
                                } else {
                                    $activeSheet->setCellValue('D' . $fila, 'No ha sido subido');
                                }

                                $fila++;
                            }
                            $fila = 4;
                            foreach ($datosNoCumplen['series'] as $seguimiento) {
                                $activeSheet->setCellValue('F' . $fila, $seguimiento->getCentroRecoleccion()->getCliente()->getNombre());
                                $activeSheet->setCellValue('G' . $fila, $seguimiento->getCentroRecoleccion()->getNombre());
                                $activeSheet->setCellValue('H' . $fila, $seguimiento->getFechaEjecucion()->format('d-m-Y'));
                                if ($seguimiento->getArchivoEncuesta()) {
                                    $url = $this->getRequest()->getSchemeAndHttpHost() . $seguimiento->getArchivoEncuesta();
                                    $activeSheet->setCellValue('I' . $fila, 'Ver Archivo');
                                    $activeSheet->getCell('I' . $fila)->getHyperlink()->setUrl($url);
                                    $link_style_array = [
                                        'font' => [
                                            'color' => ['rgb' => '0000FF'],
                                            'underline' => 'single'
                                        ]
                                    ];
                                    $activeSheet->getStyle("I" . $fila)->applyFromArray($link_style_array);
                                } else {
                                    $activeSheet->setCellValue('I' . $fila, 'No ha sido subido');
                                }

                                $fila++;
                            }
                            $objDrawing = new \PHPExcel_Worksheet_Drawing();
                            $objDrawing->setName('Grafica');
                            $objDrawing->setDescription('Grafica');
                            $objDrawing->setPath($imagenGrafica);
                            $objDrawing->setCoordinates('J2');
                            $objDrawing->setWorksheet($activeSheet);

                            // create the writer
                            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                            $response = $this->get('phpexcel')->createStreamedResponse($writer);
                            // adding headers
                            $dispositionHeader = $response->headers->makeDisposition(
                                    ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte PMIRS.xls'
                            );
                            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                            $response->headers->set('Pragma', 'public');
                            $response->headers->set('Cache-Control', 'maxage=1');
                            $response->headers->set('Content-Disposition', $dispositionHeader);
                            return $response;
                        }
                    }
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);
                    $isFormValid = false;
                }
            }
        }
        $view = $form->createView();
        return $this->render("FrontendBundle:Reportes:Checklist/base_edit.html.twig", array(
                    'action' => 'create',
                    'form' => $view,
                    'ruta' => 'informes'
        ));
    }

    public function capacitacionesAction(Request $request) {

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->createForm(new RCapacitacionesFormType($this->container));

        if ($request->getMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();
            if ($isFormValid) {
                try {
                    $datos = $this->dataReporteCapacitaciones($form);
                    if ($this->get('request')->get('pdf')) {
                        $html = $this->renderView("FrontendBundle:Reportes:Capacitaciones/template_grafica_pdf.html.twig", array(
                            'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                            'datos' => $datos['series'],
                            'titulo' => $datos['titulo'],
                        ));
                        return new Response(
                                $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                    'orientation' => 'Landscape',
                                    'margin-left' => 15,
                                    'footer-html' => $this->getFooter(),
                                    'images' => true,
                                    'enable-javascript' => true
                                )), 200, array(
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="Reporte capacitaciones.pdf"'
                                )
                        );
                    } elseif ($this->get('request')->get('excel')) {
                        $phpExcelObject = new \PHPExcel();
                        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                        $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                        $phpExcelObject->getActiveSheet()->setTitle("Reporte operativo");
                        $activeSheet->getDefaultColumnDimension()->setWidth(20);
                        $activeSheet
                                ->setCellValue('B1', $datos['titulo'])
                                ->setCellValue('A3', 'Cliente')
                                ->setCellValue('B3', 'Centro de costo')
                                ->setCellValue('C3', 'Gestor ambiental')
                                ->setCellValue('D3', 'Fecha de capacitación')
                                ->setCellValue('E3', 'Número de asistentes')
                                ->setCellValue('G3', 'Número de asistentes')
                                ->setCellValue('G3', 'Archivo')
                        ;
                        $activeSheet->mergeCells('B1:F1');
                        $fila = 4;
                        foreach ($datos['series'] as $capacitacion) {
                            $activeSheet->setCellValue('A' . $fila, $capacitacion->getCentroRecoleccion()->getCliente()->getNombre());
                            $activeSheet->setCellValue('B' . $fila, $capacitacion->getCentroRecoleccion()->getNombre());
                            $activeSheet->setCellValue('C' . $fila, $capacitacion->getGestor()->getUsername());
                            $activeSheet->setCellValue('D' . $fila, $capacitacion->getFechaActualizacion()->format('d-m-Y'));
                            $activeSheet->setCellValue('E' . $fila, $capacitacion->getNumeroAsistentes());
                            $activeSheet->setCellValue('F' . $fila, $capacitacion->getTipoCapacitacion());
                            if ($capacitacion->getArchivoCapacitacion()) {
                                $url = $this->getRequest()->getSchemeAndHttpHost() . $capacitacion->getArchivoCapacitacion();
                                $activeSheet->setCellValue('G' . $fila, 'Ver Archivo');
                                $activeSheet->getCell('G' . $fila)->getHyperlink()->setUrl($url);
                                $link_style_array = [
                                    'font' => [
                                        'color' => ['rgb' => '0000FF'],
                                        'underline' => 'single'
                                    ]
                                ];
                                $activeSheet->getStyle("G" . $fila)->applyFromArray($link_style_array);
                            } else {
                                $activeSheet->setCellValue('G' . $fila, 'No ha sido subido');
                            }
                            $fila++;
                        }
                        // create the writer
                        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                        $response = $this->get('phpexcel')->createStreamedResponse($writer);
                        // adding headers
                        $dispositionHeader = $response->headers->makeDisposition(
                                ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte de capacitaciones.xls'
                        );
                        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                        $response->headers->set('Pragma', 'public');
                        $response->headers->set('Cache-Control', 'maxage=1');
                        $response->headers->set('Content-Disposition', $dispositionHeader);
                        return $response;
                    }
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);
                    $isFormValid = false;
                }
            }
        }
        $view = $form->createView();
        return $this->render("FrontendBundle:Reportes:Capacitaciones/base_edit.html.twig", array(
                    'action' => 'create',
                    'form' => $view,
                    'ruta' => 'informes'
        ));
    }

    public function economicoAction(Request $request) {


        /** @var $form \Symfony\Component\Form\Form */
        $formEconomico = $this->createForm(new RDetalladoEconomicoFormType($this->container));

        if ($request->getMethod() == 'POST') {
            $formEconomico->submit($this->get('request'));

            $isFormValid = $formEconomico->isValid();
            if ($isFormValid) {
                try {
                    $nombre_grafica = "economico";
                    $datos = $this->dataReporteDetalladoEconomico($formEconomico);
                    $titulo = $datos['titulo'];
                    if ($request->isXmlHttpRequest()) {
                        return $this->render("FrontendBundle:Reportes:Economico/template_grafica.html.twig", array(
                                    'nombre_grafica' => $nombre_grafica,
                                    'datos' => $datos['series'],
                                    'titulo' => $titulo,
                        ));
                    } else {
                        $base64 = $formEconomico->get('imagen_grafica')->getData();
                        if ($this->get('request')->get('pdf')) {
                            $html = $this->renderView("FrontendBundle:Reportes:Economico/template_grafica_pdf.html.twig", array(
                                'base_dir' => $this->container->get('kernel')->getRootDir() . '/../web/',
                                'nombre_grafica' => $nombre_grafica,
                                'datos' => $datos['series'],
                                'graficaBase64' => $base64
                            ));
                            return new Response(
                                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                                        'orientation' => 'Landscape',
                                        'margin-left' => 15,
                                        'footer-html' => $this->getFooter(),
                                        'images' => true,
                                        'enable-javascript' => true
                                    )), 200, array(
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="Reporte economico.pdf"'
                                    )
                            );
                        } elseif ($this->get('request')->get('excel')) {
                            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                            $ruta_temp = $this->container->get('kernel')->getRootDir() . '/../web/uploads/temp/';
                            $nombreTemporal = md5(uniqid()) . "png";
                            file_put_contents($ruta_temp . $nombreTemporal, $data);
                            $imagenGrafica = $ruta_temp . $nombreTemporal;
                            $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
                            $activeSheet = $phpExcelObject->setActiveSheetIndex(0);
                            $phpExcelObject->getActiveSheet()->setTitle("Reporte tipos de residuos");
                            $activeSheet->getDefaultColumnDimension()->setWidth(20);
                            $activeSheet
                                    ->setCellValue('B1', $datos['titulo'])
                                    ->setCellValue('A3', 'Tipo de residuo')
                                    ->setCellValue('B3', 'Peso en Kg');
                            $activeSheet->mergeCells('B1:F1');
                            $fila = 4;
                            foreach ($datos['series'] as $tipoResiduo) {
                                $activeSheet->setCellValue('A' . $fila, $tipoResiduo['nombre']);
                                $peso = number_format($tipoResiduo['precio'], 3, ',', '.');
                                $activeSheet->setCellValue('B' . $fila, $peso);
                                $fila++;
                            }
                            $objDrawing = new \PHPExcel_Worksheet_Drawing();
                            $objDrawing->setName('Grafica');
                            $objDrawing->setDescription('Grafica');
                            $objDrawing->setPath($imagenGrafica);
                            $objDrawing->setCoordinates('D2');
                            $objDrawing->setWorksheet($activeSheet);

                            // create the writer
                            $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                            $response = $this->get('phpexcel')->createStreamedResponse($writer);
                            // adding headers
                            $dispositionHeader = $response->headers->makeDisposition(
                                    ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'Reporte economico.xls'
                            );
                            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
                            $response->headers->set('Pragma', 'public');
                            $response->headers->set('Cache-Control', 'maxage=1');
                            $response->headers->set('Content-Disposition', $dispositionHeader);
                            return $response;
                        }
                    }
                } catch (ModelManagerException $e) {
                    $this->logModelManagerException($e);
                    $isFormValid = false;
                }
            }
        }
        $viewEconomico = $formEconomico->createView();
        return $this->render("FrontendBundle:Reportes:Economico/base_edit.html.twig", array(
                    'action' => 'create',
                    'form' => $viewEconomico,
                    'ruta' => 'informes'
        ));
    }

    public function dataReporteDetalladoTipos(Form $data) {
        $cliente = $data->get('cliente')->getData();
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $tipoResiduo = $data->get('tipo_residuo')->getData();
        $series = array();
        $titulo = "";
        if ($tipoResiduo) {
            $titulo .= 'Residuos de la categoría ' . $tipoResiduo->getNombre() . ' y su peso en Kg';
            $em = $this->getDoctrine()->getManager();
            $sql = "SELECT r.nombre,sum(rr.peso) AS peso FROM residuo r";
            $sql .= " INNER JOIN residuo_recoleccion rr ON r.id = rr.residuo_id";
            $sql .= " INNER JOIN recoleccion rec ON rr.recoleccion_id = rec.id";
            $sql .= " INNER JOIN tipo_residuo_transporte trt ON rec.tipo_residuo_transporte_id = trt.id";
            $sql .= " INNER JOIN tipo_residuo tr ON trt.tipo_residuo_id = tr.id";
            $sql .= " INNER JOIN programacion p ON trt.programacion_id = p.id";
            $sql .= " INNER JOIN centro_recoleccion cc ON p.centro_recoleccion_id = cc.id";
            $where = " WHERE";
            if ($cliente) {
                $titulo .= " del cliente $cliente.";
                $sql .= $where . " cc.cliente_id = " . $cliente->getId();
                $where = " AND";
            }
            if ($fechaInicial) {
                $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
                $sql .= $where . " rec.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
                $where = " AND";
            }
            if ($fechaFinal) {
                $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
                $sql .= $where . " rec.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
            }
            $sql .= $where . " trt.tipo_residuo_id = " . $tipoResiduo->getId();
            $sql .= " GROUP  BY r.nombre";
            $conn = $em->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $residuos = $stmt->fetchAll();

            foreach ($tipoResiduo->getResiduos() as $residuoObject) {
                $peso = 0;
                $serie = array(
                    'nombre' => $residuoObject->getNombre(),
                    'color' => $tipoResiduo->getColor(),
                );
                foreach ($residuos as $residuo) {
                    if ($residuoObject->getNombre() == $residuo['nombre']) {
                        $peso = (float) $residuo['peso'];
                    }
                }
                $serie['peso'] = $peso;
                $series[] = $serie;
            }
        }
        return array('series' => $series, 'titulo' => $titulo);
    }

    public function dataReporteDetalladoFechas($data) {
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $cliente = $data->get('cliente')->getData();
        if (!$fechaInicial) {
            $fechaInicial = new \DateTime(date('Y') . '-01-01');
        }
        if (!$fechaFinal) {
            $fechaFinal = new \DateTime(date('Y') . '-12-31');
        }
        $tipos_residuos = $data->get('tipos_residuos')->getData();
        $idsResiduos = array();
        foreach ($tipos_residuos as $tipo) {
            $idsResiduos[] = $tipo->getId();
        }
        $titulo = 'Tipos de residuos mensuales y su peso en Kg';
        if ($cliente) {
            $titulo .= " del cliente " . $cliente->getNombre() . ".";
        }
        $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
        $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
        $interval = new \DateInterval('P1M');
        $period = new \DatePeriod($fechaInicial, $interval, $fechaFinal);

        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $tiposResiduos = $em->getRepository('ModelBundle:TipoResiduo')->findAll();
        $fechas = array();
        foreach ($period as $dt) {
            $first_of_month = $dt->modify('first day of this month')->format('Y-m-d H:i:s');
            $end_of_month = $dt->modify('last day of this month')->format('Y-m-d');
            $sql = "SELECT DATE_FORMAT(r.fecha_recoleccion_ejecutada,'%Y-%m') fecha, tr.nombre,tr.color,SUM(rr.peso) AS peso FROM recoleccion r ";
            $sql .= " INNER JOIN tipo_residuo_transporte trt on  trt.id = r.tipo_residuo_transporte_id ";
            $sql .= " INNER JOIN programacion p on  trt.programacion_id = p.id ";
            $sql .= " INNER JOIN centro_recoleccion cr on  p.centro_recoleccion_id = cr.id ";
            $sql .= " INNER JOIN tipo_residuo tr on  trt.tipo_residuo_id = tr.id ";
            $sql .= " INNER JOIN residuo_recoleccion rr on r.id = rr.recoleccion_id ";
            $sql .= " WHERE r.fecha_recoleccion_ejecutada >= '" . $first_of_month . "' ";
            $sql .= " AND r.fecha_recoleccion_ejecutada <= '" . $end_of_month . " 23:59:59'";

            if (!empty($idsResiduos)) {
                $sql .= " AND tr.id IN (" . implode(',', $idsResiduos) . ")";
            }
            if ($cliente) {
                $sql .= " AND cr.cliente_id = " . $cliente->getId();
            }
            $sql .= " GROUP BY fecha,tr.id";
            $sql .= " ORDER BY fecha asc ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $residuos = $stmt->fetchAll();
            $year = $dt->format('Y');
            $month = $dt->format('m');
            switch ($month) {
                case 1:
                    $month = "Enero";
                    break;
                case 2:
                    $month = "Febrero";
                    break;
                case 3:
                    $month = "Marzo";
                    break;
                case 4:
                    $month = "Abril";
                    break;
                case 5:
                    $month = "Mayo";
                    break;
                case 6:
                    $month = "Junio";
                    break;
                case 7:
                    $month = "Julio";
                    break;
                case 8:
                    $month = "Agosto";
                    break;
                case 9:
                    $month = "Septiembre";
                    break;
                case 10:
                    $month = "Octubre";
                    break;
                case 11:
                    $month = "Noviembre";
                    break;
                case 12:
                    $month = "Diciembre";
                    break;
                default:
                    break;
            }
            $fechas[$year . "-" . $month] = array();
            foreach ($tiposResiduos as $tipoResiduo) {
                $fechas[$year . "-" . $month][$tipoResiduo->getNombre()] = array();
                $fechas[$year . "-" . $month][$tipoResiduo->getNombre()]['color'] = $tipoResiduo->getColor();
                $peso = 0;
                foreach ($residuos as $residuo) {
                    if ($residuo['nombre'] == $tipoResiduo->getNombre()) {
                        $peso = $residuo['peso'];
                    }
                }
                $fechas[$year . "-" . $month][$tipoResiduo->getNombre()]['peso'] = $peso;
            }
        }
        return array(
            'series' => $fechas,
            'tiposResiduos' => $tiposResiduos,
            'titulo' => $titulo
        );
    }

    public function dataReporteDetalladoAprovechables($data) {
        $cliente = $data->get('cliente')->getData();
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $titulo = 'Residuos Aprovechables Vs No Aprovechables';
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT";
        $sql .= "( SELECT SUM(rr.peso) AS peso FROM residuo_recoleccion rr INNER JOIN recoleccion r ON rr.recoleccion_id = r.id INNER JOIN tipo_residuo_transporte trt ON r.tipo_residuo_transporte_id = trt.id INNER JOIN tipo_residuo tr ON trt.tipo_residuo_id = tr.id INNER JOIN programacion p ON trt.programacion_id = p.id INNER JOIN centro_recoleccion cc ON p.centro_recoleccion_id = cc.id 
        WHERE rr.reciclabe = " . TRUE;

        if ($cliente) {
            $titulo .= " del cliente $cliente.";
            $sql .= " AND cc.cliente_id = " . $cliente->getId();
        }
        if ($fechaInicial) {
            $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
            $sql .= " AND r.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
        }
        if ($fechaFinal) {
            $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
            $sql .= " AND r.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
        }
        $sql .= ") as Aprovechables,";

        $sql .= "( SELECT SUM(rr.peso) AS peso FROM residuo_recoleccion rr INNER JOIN recoleccion r ON rr.recoleccion_id = r.id INNER JOIN tipo_residuo_transporte trt ON r.tipo_residuo_transporte_id = trt.id INNER JOIN tipo_residuo tr ON trt.tipo_residuo_id = tr.id INNER JOIN programacion p ON trt.programacion_id = p.id INNER JOIN centro_recoleccion cc ON p.centro_recoleccion_id = cc.id 
        WHERE rr.reciclabe = false";

        if ($cliente) {
            $sql .= " AND cc.cliente_id = " . $cliente->getId();
        }
        if ($fechaInicial) {
            $sql .= " AND r.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
        }
        if ($fechaFinal) {
            $sql .= " AND r.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
        }
        $sql .= ") as 'No aprovechables'";
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $aprovechablesNoAprovechables = $stmt->fetchAll();
        return array('series' => $aprovechablesNoAprovechables, 'titulo' => $titulo);
    }

    public function dataReporteDetalladoEconomico($data) {
        $cliente = $data->get('cliente')->getData();
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $tipos_residuos = $data->get('tipos_residuos')->getData();
        $idsResiduos = array();
        foreach ($tipos_residuos as $tipo) {
            $idsResiduos[] = $tipo->getId();
        }
        $titulo = 'Reporte ecónomico';
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT tr.nombre,tr.color,(SUM(rr.precio * rr.peso)) AS precio FROM tipo_residuo tr";
        $sql .= " INNER JOIN tipo_residuo_transporte trt on tr.id = trt.tipo_residuo_id";
        $sql .= " INNER JOIN programacion p on trt.programacion_id = p.id";
        $sql .= " INNER JOIN centro_recoleccion cc on p.centro_recoleccion_id = cc.id";
        $sql .= " INNER JOIN recoleccion r on trt.id = r.tipo_residuo_transporte_id";
        $sql .= " INNER JOIN residuo_recoleccion rr on r.id = rr.recoleccion_id";
        $where = " WHERE";
        if ($cliente) {
            $titulo .= " del cliente $cliente.";
            $sql .= $where . " cc.cliente_id = " . $cliente->getId();
            $where = " AND";
        }
        if ($fechaInicial) {
            $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
            $sql .= $where . " r.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
            $where = " AND";
        }
        if ($fechaFinal) {
            $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
            $sql .= $where . " r.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
        }
        if (!empty($idsResiduos)) {
            $sql .= $where . " tr.id IN (" . implode(',', $idsResiduos) . ")";
        }
        $sql .= " GROUP BY tr.id";
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tiposResiduos = $stmt->fetchAll();
        return array('series' => $tiposResiduos, 'titulo' => $titulo);
    }

    public function dataReporteOperativo($data) {
        $cliente = $data->get('cliente')->getData();
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $series = array();
        $titulo = 'Tipos de residuos y su porcentaje en peso,';
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT tr.nombre,tr.color,sum(rr.peso) AS peso FROM tipo_residuo tr";
        $sql .= " INNER JOIN tipo_residuo_transporte trt ON tr.id= trt.tipo_residuo_id";
        $sql .= " INNER JOIN programacion p ON trt.programacion_id = p.id ";
        $sql .= " INNER JOIN centro_recoleccion cc ON p.centro_recoleccion_id = cc.id";
        $sql .= " INNER JOIN recoleccion rec ON trt.id= rec.tipo_residuo_transporte_id";
        $sql .= " INNER JOIN residuo_recoleccion rr ON rr.recoleccion_id = rec.id ";
        $where = " WHERE";
        if ($cliente) {
            $titulo .= " del cliente $cliente.";
            $sql .= $where . " cc.cliente_id = " . $cliente->getId();
            $where = " AND";
        }
        if ($fechaInicial) {
            $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
            $sql .= $where . " rec.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
            $where = " AND";
        }
        if ($fechaFinal) {
            $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
            $sql .= $where . " rec.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
        }
        $sql .= " GROUP  BY tr.id";
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tipos_residuos = $stmt->fetchAll();
        $tiposResiduosObject = $em->getRepository('ModelBundle:TipoResiduo')->findAll();

        foreach ($tiposResiduosObject as $tipoResiduoObject) {
            $peso = 0;
            $serie = array(
                'nombre' => $tipoResiduoObject->getNombre(),
                'color' => $tipoResiduoObject->getColor(),
            );
            foreach ($tipos_residuos as $tipo_residuo) {
                if ($tipoResiduoObject->getNombre() == $tipo_residuo['nombre']) {
                    $peso = (float) $tipo_residuo['peso'];
                }
            }
            $serie['peso'] = $peso;
            $series[] = $serie;
        }
        return array('series' => $series, 'titulo' => $titulo);
    }

    public function dataReporteDetalladoGestor($data) {
        $gestor_ambiental_id = $data->get('gestor_ambiental')->getData();
        $tipos_residuos = array();
        $titulo = 'Tipos de residuos y su peso en Kg';
        $series = array();
        if ($gestor_ambiental_id) {
            $em = $this->getDoctrine()->getManager();
            $fechaInicial = $data->get('fecha_inicial')->getData();
            $fechaFinal = $data->get('fecha_final')->getData();
            $gestor_ambiental = $em->getRepository('ModelBundle:User')->find($gestor_ambiental_id);
            $sql = "SELECT tr.nombre,tr.color,sum(rr.peso) AS peso FROM tipo_residuo tr";
            $sql .= " INNER JOIN tipo_residuo_transporte trt ON tr.id= trt.tipo_residuo_id";
            $sql .= " INNER JOIN programacion p ON trt.programacion_id = p.id ";
            $sql .= " INNER JOIN centro_recoleccion cc ON p.centro_recoleccion_id = cc.id";
            $sql .= " INNER JOIN recoleccion rec ON trt.id= rec.tipo_residuo_transporte_id";
            $sql .= " INNER JOIN residuo_recoleccion rr ON rr.recoleccion_id = rec.id ";
            $titulo .= " del gestor ambiental " . $gestor_ambiental->getUsername() . ".";
            $sql .= " WHERE p.gestor_ambiental_id = " . $gestor_ambiental_id;
            if ($fechaInicial) {
                $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
                $sql .= " AND rec.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
            }
            if ($fechaFinal) {
                $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
                $sql .= " AND rec.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
            }
            $sql .= " GROUP  BY tr.id";
            $conn = $em->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $tipos_residuos = $stmt->fetchAll();

            $tiposResiduosObject = $em->getRepository('ModelBundle:TipoResiduo')->findAll();

            foreach ($tiposResiduosObject as $tipoResiduoObject) {
                $peso = 0;
                $serie = array(
                    'nombre' => $tipoResiduoObject->getNombre(),
                    'color' => $tipoResiduoObject->getColor(),
                );
                foreach ($tipos_residuos as $tipo_residuo) {
                    if ($tipoResiduoObject->getNombre() == $tipo_residuo['nombre']) {
                        $peso = (float) $tipo_residuo['peso'];
                    }
                }
                $serie['peso'] = $peso;
                $series[] = $serie;
            }
        }
        return array('series' => $series, 'titulo' => $titulo);
    }

    public function dataReporteCapacitaciones($data) {
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $cliente = $data->get('cliente')->getData();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('ModelBundle:Capacitacion')->createQueryBuilder('c');
        $titulo = "Reporte de capacitaciones";
        if ($cliente) {
            $titulo .= " del cliente " . $cliente->getNombre() . ".";
            $qb->join('c.centro_recoleccion', 'cc');
            $qb->andWhere('cc.cliente = :cliente')
                    ->setParameter('cliente', $cliente);
        }
        if ($fechaInicial) {
            $titulo .= " desde " . $fechaInicial->format('Y-m-d');
            $qb->andWhere('c.fechaCapacitacion >= :fechaInicio')
                    ->setParameter('fechaInicio', $fechaInicial->format('Y-m-d') . " 0:0:0");
        }
        if ($fechaFinal) {
            $titulo .= " hasta " . $fechaInicial->format('Y-m-d');
            $qb->andWhere('c.fechaCapacitacion <= :fechaFinal')
                    ->setParameter('fechaFinal', $fechaFinal->format('Y-m-d') . " 23:59:59");
        }
        $qb->orderBy('c.fechaCapacitacion', 'ASC');
        $query = $qb->getQuery();
        return array('series' => $query->getResult(), 'titulo' => $titulo);
    }

    public function dataReporteChecklist($data, $seguimiento) {
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $cliente = $data->get('cliente')->getData();
        $centro_costo_id = $data->get('centro_costo')->getData();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('ModelBundle:SeguimientoPMIRS')->createQueryBuilder('s');
        $titulo = "Reporte PMIRS";
        $qb->join('s.centro_recoleccion', 'cr');
        $qb->andWhere('s.cumple_seguimiento =' . $seguimiento);
        if ($centro_costo_id) {
            $centro_costo = $em->getRepository('ModelBundle:CentroRecoleccion')->find($centro_costo_id);
            $titulo .= " del centro de costo " . $centro_costo->getNombre();
            $qb->andWhere('s.centro_recoleccion = :centro')
                    ->setParameter('centro', $centro_costo);
        }
        if ($cliente) {
            $titulo .= " del cliente " . $cliente->getNombre() . ".";
            $qb->andWhere('cr.cliente = :cliente')
                    ->setParameter('cliente', $cliente);
        }
        if ($fechaInicial) {
            $titulo .= " Desde " . $fechaInicial->format('Y-m-d');
            $qb->andWhere('s.fecha_ejecucion >= :fechaInicio')
                    ->setParameter('fechaInicio', $fechaInicial->format('Y-m-d') . " 0:0:0");
        }
        if ($fechaFinal) {
            $titulo .= " hasta " . $fechaInicial->format('Y-m-d');
            $qb->andWhere('s.fecha_ejecucion <= :fechaFinal')
                    ->setParameter('fechaFinal', $fechaFinal->format('Y-m-d') . " 23:59:59");
        }
        $qb->orderBy('s.fecha_ejecucion', 'ASC');
        $query = $qb->getQuery();
        return array('series' => $query->getResult(), 'titulo' => $titulo);
    }

    public function dataReporteResiduosDisposicion($data) {
        $cliente = $data->get('cliente')->getData();
        $fechaInicial = $data->get('fecha_inicial')->getData();
        $fechaFinal = $data->get('fecha_final')->getData();
        $tipoResiduo = $data->get('tipo_residuo')->getData();
        $series = array();
        $em = $this->getDoctrine()->getManager();
        $titulo = 'Tipos de residuos y disposiciones finales';
        if ($tipoResiduo) {
            $titulo = 'Residuos ' . $tipoResiduo->getNombre() . ' y sus disposiciones finales';
            $sql = "SELECT COUNT(d.nombre) AS cantidad,d.nombre FROM disposicion d";
            $sql .= " INNER JOIN residuo_recoleccion rr on d.id = rr.disposicion_id";
            $sql .= " INNER JOIN recoleccion r on rr.recoleccion_id = r.id";
            $sql .= " INNER JOIN tipo_residuo_transporte trt on r.tipo_residuo_transporte_id = trt.id";
            $sql .= " INNER JOIN programacion p on trt.programacion_id = p.id";
            $sql .= " INNER JOIN centro_recoleccion cr on p.centro_recoleccion_id= cr.id";
            $sql .= " WHERE trt.tipo_residuo_id = " . $tipoResiduo->getId();
            if ($cliente) {
                $titulo .= " del cliente $cliente.";
                $sql .= " AND cr.cliente_id = " . $cliente->getId();
            }
            if ($fechaInicial) {
                $titulo .= " Desde " . date_format($fechaInicial, "d-m-Y");
                $sql .= " AND r.fecha_recoleccion_ejecutada >= '" . date_format($fechaInicial, "Y-m-d") . " 0:0:0'";
            }
            if ($fechaFinal) {
                $titulo .= " Hasta " . date_format($fechaFinal, "d-m-Y");
                $sql .= " AND r.fecha_recoleccion_ejecutada <= '" . date_format($fechaFinal, "Y-m-d") . " 23:59:59'";
            }
            $sql .= " GROUP BY d.nombre";
            $sql .= " ORDER BY cantidad DESC";
            $conn = $em->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $tipos_residuos = $stmt->fetchAll();
            $series = $tipos_residuos;
        }
        return array('series' => $series, 'titulo' => $titulo);
    }

    public function getFooter() {
        return $this->get('kernel')->getRootDir() . "/../src/FrontendBundle/Resources/views/Reportes/footer_pdf.html";
    }

}
