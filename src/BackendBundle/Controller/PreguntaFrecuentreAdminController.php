<?php

namespace BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PreguntaFrecuentreAdminController extends CRUDController {
    protected function getJpgOptions() {
        return ['width' => 2480, 'height' => 3508];
    }

    protected function getPdfOptions() {
//        return ['orientation' => 'landscape'];
        return [];
    }
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
     * List action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function listAction() {
        if ($this->getUser()->hasRole('ROLE_GESTOR')) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->getRepository('ModelBundle:PreguntaFrecuentre')->createQueryBuilder('p');
            $query = $qb->where("p.roles like '%ROLE_GESTOR%'")->getQuery();
            $preguntas = $query->getResult();
            return $this->render("BackendBundle:PreguntaFrecuente:base_list.html.twig", array(
                        'action' => 'list',
                        'preguntas' => $preguntas,
            ));
        }
        $request = $this->getRequest();

        $this->admin->checkAccess('list');

        $preResponse = $this->preList($request);
        if ($preResponse !== null) {
            return $preResponse;
        }

        if ($listMode = $request->get('_list_mode')) {
            $this->admin->setListMode($listMode);
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
                    'action' => 'list',
                    'form' => $formView,
                    'datagrid' => $datagrid,
                    'csrf_token' => $this->getCsrfToken('sonata.batch'),
                        ), null, $request);
    }

}
