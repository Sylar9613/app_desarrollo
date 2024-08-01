<?php

namespace App\Controller;

use App\Entity\AccionPAM;
use App\Entity\Entidad;
use App\Entity\Log;
use App\Form\AccionPAMType;
use App\Form\EntidadType;
use App\Repository\AccionPAMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/pam/accionpam")
 */
class AccionPAMController extends AbstractController
{
    /**
     * @Route("/", name="accionpam_index", methods={"GET"})
     */
    public function index(AccionPAMRepository $accionPAMRepository, Request $request): Response
    {
        return $this->render('pam/accionpam/index.html.twig', [
            'acciones' => $accionPAMRepository->findAll(),
            'url' => 'pam',
            'routes' => ['PAM', 'Acciones'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="accionpam_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $accionPAM = new AccionPAM();
        $form = $this->createForm(AccionPAMType::class, $accionPAM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Insertar accion del PAM');
            $entityManager->persist($bitacora);
            $entityManager->persist($accionPAM);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Acción PAM registrada!'
            );

            return $this->redirectToRoute('accionpam_index');
        }

        return $this->render('pam/accionpam/new.html.twig', [
            'accionpam' => $accionPAM,
            'form' => $form->createView(),
            'url' => 'pam',
            'routes' => ['PAM', 'Acciones', 'Nueva'],
        ]);
    }

    /**
     * @Route("/{id}", name="accionpam_show", methods={"GET"})
     */
    public function show(AccionPAM $accionPAM, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        return $this->render('pam/accionpam/show.html.twig', [
            'accionpam' => $accionPAM,
            'url' => 'pam',
            'routes' => ['PAM', 'Acciones', 'Ver'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="accionpam_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AccionPAM $accionPAM): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $form = $this->createForm(AccionPAMType::class, $accionPAM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Modificar acción del PAM: '.$accionPAM->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'Acción PAM actualizada!'
            );

            return $this->redirectToRoute('accionpam_index');
        }

        return $this->render('pam/accionpam/edit.html.twig', [
            'accionpam' => $accionPAM,
            'form' => $form->createView(),
            'url' => 'pam',
            'routes' => ['PAM', 'Acciones', 'Editar'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/activate", name="accionpam_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, AccionPAM $accionPAM): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $accionPAM->setActivo(true);
        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Activar acción del PAM: '.$accionPAM->getId());
        $this->getDoctrine()->getManager()->persist($bitacora);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'notice',
            'Acción PAM activada!'
        );
        return $this->redirectToRoute('accionpam_index');
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/deactivate", name="accionpam_deactivate", methods={"GET","POST"})
     */
    public function deactivate(Request $request, AccionPAM $accionPAM)
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());

        $accionPAM->setActivo(false);
        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Desactivar acción del PAM: '.$accionPAM->getId());
        $this->getDoctrine()->getManager()->persist($bitacora);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'notice',
            'Acción PAM desactivada!'
        );

        return false;
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="accionpam_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AccionPAM $accionPAM): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accionPAM->getId(), $request->request->get('_token'))) {
            if ($this->deactivate($request, $accionPAM))
            {
                return $this->redirectToRoute('accionpam_show', array('id'=>$accionPAM->getId()));
            }
        }

        return $this->redirectToRoute('accionpam_index');
    }
}
