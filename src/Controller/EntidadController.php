<?php

namespace App\Controller;

use App\Entity\Entidad;
use App\Entity\Log;
use App\Form\EntidadType;
use App\Repository\AccionPAMRepository;
use App\Repository\EntidadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/entidad")
 */
class EntidadController extends AbstractController
{
    /**
     * @Route("/", name="entidad_index", methods={"GET"})
     */
    public function index(EntidadRepository $entidadRepository, Request $request): Response
    {
        return $this->render('entidad/index.html.twig', [
            'entidades' => $entidadRepository->findAll(),
            'url' => 'entidades',
            'routes' => ['Empleos', 'Entidad'],
        ]);
    }

    /**
     * Filter all entidades by ai and/or osdes and/or organismos
     *
     * @Route("/", name="ent_filter", methods={"GET", "POST"})
     */
    public function filterAction(Request $request, AccionPAMRepository $entidadRepository)
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $idorg = $request->request->get('filtrar_org');
        $idosde = $request->request->get('filtrar_osde');
        $ai = $request->request->get('filtrar_ai');

        $em = $this->getDoctrine()->getManager();

        if($idorg=='todos')
        {
            if ($idosde=='todas')
            {
                if ($ai=='todos')
                {
                    return $this->redirectToRoute("entidad_index");
                }
                elseif ($ai=='yes')
                {
                    $entidads = $entidadRepository->findBy(array('ai'=>'1'));
                }
                else
                {
                    $entidads = $entidadRepository->findBy(array('ai'=>'0'));
                }
            }
            else
            {
                if ($ai=='todos')
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>$idosde));
                }
                elseif ($ai=='yes')
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>$idosde, 'ai'=>'1'));
                }
                else
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>$idosde, 'ai'=>'0'));
                }
            }
        }
        else
        {
            if ($idosde=='todas')
            {
                if ($ai=='todos')
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>array('organismo'=>$idorg)));
                }
                elseif ($ai=='yes')
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>array('organismo'=>$idorg), 'ai'=>'1'));
                }
                else
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>array('organismo'=>$idorg), 'ai'=>'0'));
                }
            }
            else
            {
                if ($ai=='todos')
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>array('organismo'=>$idorg), 'osde'=>$idosde));
                }
                elseif ($ai=='yes')
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>array('organismo'=>$idorg), 'osde'=>$idosde, 'ai'=>'1'));
                }
                else
                {
                    $entidads = $entidadRepository->findBy(array('osde'=>array('organismo'=>$idorg), 'osde'=>$idosde, 'ai'=>'0'));
                }
            }
        }

        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Filtrar entidad');
        $em->persist($bitacora);
        $em->flush();

        return $this->render("entidad/index.html.twig", array(
            'entidads' => $entidads,
            'osdes' => $osdeRepository->findBy(array('activo'=>1)),
            'organismos' => $organismoRepository->findBy(array('activo'=>1)),
            'url'=>'clasificador',
            'routes' => ['Empleos', 'Entidad'],
        ));
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="entidad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $entidad = new Entidad();
        $form = $this->createForm(EntidadType::class, $entidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Insertar entidad');
            $entityManager->persist($bitacora);
            $entityManager->persist($entidad);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Entidad registrada!'
            );

            return $this->redirectToRoute('entidad_index');
        }

        return $this->render('entidad/new.html.twig', [
            'entidad' => $entidad,
            'form' => $form->createView(),
            'url' => 'entidades',
            'routes' => ['Empleos', 'Entidad', 'Nueva'],
        ]);
    }

    /**
     * @Route("/{id}", name="entidad_show", methods={"GET"})
     */
    public function show(Entidad $entidad, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        return $this->render('entidad/show.html.twig', [
            'entidad' => $entidad,
            'url' => 'entidades',
            'routes' => ['Empleos', 'Entidad', 'Ver'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="entidad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entidad $entidad): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $form = $this->createForm(EntidadType::class, $entidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Modificar entidad: '.$entidad->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'Entidad actualizada!'
            );

            return $this->redirectToRoute('entidad_index');
        }

        return $this->render('entidad/edit.html.twig', [
            'entidad' => $entidad,
            'form' => $form->createView(),
            'url' => 'entidades',
            'routes' => ['Empleos', 'Entidad', 'Editar'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/activate", name="entidad_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, Entidad $entidad): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $entidad->setActivo(true);
        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Activar entidad: '.$entidad->getId());
        $this->getDoctrine()->getManager()->persist($bitacora);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'notice',
            'Entidad activada!'
        );
        return $this->redirectToRoute('entidad_index');
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/deactivate", name="entidad_deactivate", methods={"GET","POST"})
     */
    public function deactivate(Request $request, Entidad $entidad)
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());

        $auditor = $entidad->getAuditores();
        $plazas = $entidad->getPlazas();

        if (count($auditor) > 0 || count($plazas) > 0)
        {
            $this->addFlash(
                'error',
                'No se puede eliminar esta entidad porque existe algún auditor en su plantilla!'
            );

            return true;
        }
        else
        {
            $entidad->setActivo(false);
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Desactivar entidad: '.$entidad->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'Entidad desactivada!'
            );

            return false;
        }
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="entidad_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entidad $entidad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entidad->getId(), $request->request->get('_token'))) {
            if ($this->deactivate($request, $entidad))
            {
                return $this->redirectToRoute('entidad_show', array('id'=>$entidad->getId()));
            }
        }

        return $this->redirectToRoute('entidad_index');
    }

    /**
     * Filter all acciones by entidad
     *
     * @Route("_download_pdf", name="download_pdf", methods={"GET","POST"})
     */
    public function pdf(Request $request)
    {
        $conn = $this->getDoctrine()->getConnection();
        $acciones = $conn
            ->fetchAll('SELECT DISTINCT accion.id,accion.nombre AS accion
                FROM accion
                ');
        $sql = $conn
            ->fetchAll('SELECT DISTINCT accion.id,accion.nombre AS accion,accion.fecha AS fecha,accion.activo AS activa,entidad.nombre AS entidad,objetivo.id AS objetivoId,objetivo.nombre AS objetivo,tipo_accion.nombre AS tipoAccion,objetivo_entidad.deficiencias AS deficiencias,objetivo_entidad.recomendaciones AS recomendaciones,objetivo_entidad.seguimiento AS seguimiento 
                    FROM accion,entidad,objetivo,tipo_accion,objetivo_entidad 
                    WHERE accion.id=objetivo_entidad.acciones_id 
                    AND objetivo.id=objetivo_entidad.objetivo_id 
                    AND entidad.id=objetivo_entidad.entidad_id
                    AND tipo_accion.id=accion.tipoaccion_id
                    ');
        $cantidadAcciones = $conn
            ->fetchAll('SELECT DISTINCT accion.id
                    FROM accion,objetivo_entidad
                    WHERE accion.id=objetivo_entidad.acciones_id');

        $reporte_name = 'Reporte de las acciones - '.date('Y/m/d h:i:s a');

        require_once(__DIR__.'/../../vendor/tcpdf/tcpdf.php');

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'ASCII', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arián Castellanos');
        $pdf->SetTitle($reporte_name);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 20, 10, false);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->setPageOrientation('L');
        $pdf->addPage();

        $content = '';
        $contador = 0;

        $content .= '
		<div class="container">		
            <div class="row">
                <div class="col-md-12">
                    <h1 style="text-align:center;">'.$reporte_name.'</h1>';
                    if (count($cantidadAcciones)==1){
                        $content .= '<h2 style="text-align:center;">Consta de '.count($cantidadAcciones).' acci&oacute;n</h2>';
                    }
                    else {
                        $content .= '<h2 style="text-align:center;">Consta de '.count($cantidadAcciones).' acciones</h2>';
                    }
                $content .= '</div>
            </div>
            <ul>
        ';

        foreach ($acciones as $index => $user) {
            $content .= '
		    <li>';
            $content .= $user['accion'];
            $empty = true;
            $content .= '<ul>';
            $fecha = $tipoAccion = $entidad = '';
            foreach ($sql as $indexSql => $item)
            {
                if ($user['accion'] === $item['accion']){
                    if ($fecha === $item['fecha'] && $tipoAccion === $item['tipoAccion'] && $entidad === $item['entidad']){
                        $content .= '<li>Objetivo No.'.$item['objetivoId'].'&nbsp;&nbsp;'.$item['objetivo'].'</li>';
                        $content .= '<ul><li>Deficiencias: '.$item['deficiencias'].'</li>';
                        $content .= '<li>Recomendaciones: '.$item['recomendaciones'].'</li>';
                        $content .= '<li>Seguimiento: '.$item['seguimiento'].'</li></ul>';
                    }
                    else {
                        $content .= '<li><b>Fecha: '.$item['fecha'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entidad: '.$item['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo de acci&oacute;n: '.$item['tipoAccion'].'</b></li>';
                        $content .= '<li>Objetivo No.'.$item['objetivoId'].'&nbsp;&nbsp;'.$item['objetivo'].'</li>';
                        $content .= '<ul><li>Deficiencias: '.$item['deficiencias'].'</li>';
                        $content .= '<li>Recomendaciones: '.$item['recomendaciones'].'</li>';
                        $content .= '<li>Seguimiento: '.$item['seguimiento'].'</li></ul>';
                    }
                    $fecha = $item['fecha'];
                    $entidad = $item['entidad'];
                    $tipoAccion = $item['tipoAccion'];
                }
                else{
                    if ($empty){
                        $content .= '<li>No hay acciones reportadas</li>';
                        $empty = false;
                    }
                }
            }
            $content .= '</ul></li>';
        }

        $content .= '</ul></div>';

        $content .= '
		<div class="row padding">
        	<div class="col-md-12" style="text-align:center;">
            	<span>Pdf Creator </span><a href="http://www.redecodifica.com">By Arián Castellanos</a>
            </div>
        </div>
    	
	';
        if ($contador == 9 || $contador == 8){
            /*var_dump($contador.' hola');die;*/
            $pdf->SetFont('Helvetica', '', 6);
        }
        elseif ($contador <= 7 && $contador >= 6){
            /*var_dump($contador.' hola2');die;*/
            $pdf->SetFont('Helvetica', '', 7);
        }
        elseif ($contador <= 5 && $contador >= 4){
            /*var_dump($contador.' hola3');die;*/
            $pdf->SetFont('Helvetica', '', 9);
        }
        else{
            $pdf->SetFont('Helvetica', '', 10);
            /*var_dump($contador.' else');die;*/
        }
        $pdf->writeHTML($content, true, 0, true, 0);

        $pdf->lastPage();
        $pdf->output('Reporte Acciones CP Matanzas '.date('Y/m/d').'.pdf', 'D');

        $em = $this->getDoctrine()->getManager();
        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Crear reporte');

        $em->persist($bitacora);
        $em->flush();

        return $this->redirectToRoute('entidad_index');
    }
}
