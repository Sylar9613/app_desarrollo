<?php
/**
 * Created by PhpStorm.
 * User: arian
 * Date: 3/noviembre/2022
 * Time: 1:12 PM
 */

namespace App\Controller;

use App\Entity\Log;
use App\Entity\PAM;
use App\Form\PAMType;
use App\Repository\LineaEstrategicaRepository;
use App\Repository\PAMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/pam")
 */
class PAMController extends AbstractController
{
    /**
     * @Route("/", name="pam_index", methods={"GET"})
     */
    public function index(PAMRepository $PAMRepository, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        return $this->render('pam/index.html.twig', [
            'pams' => $PAMRepository->findAll(),
            'url' => 'pam',
            'routes' => ['PAM'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="pam_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $pam = new PAM();

        $form = $this->createForm(PAMType::class, $pam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Insertar PAM');
            $entityManager->persist($bitacora);
            $entityManager->persist($pam);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'PAM registrado!'
            );
            return $this->redirectToRoute('pam_index');
        }

        return $this->render('pam/new.html.twig', [
            'pam' => $pam,
            'form' => $form->createView(),
            'url' => 'pam',
            'routes' => ['PAM', 'Nuevo'],
        ]);
    }

    /**
     * @Route("/{id}", name="pam_show", methods={"GET"})
     */
    public function show(PAM $PAM, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        return $this->render('pam/show.html.twig', [
            'pam' => $PAM,
            'url' => 'pam',
            'routes' => ['PAM', 'Ver'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="pam_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PAM $PAM): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $form = $this->createForm(PAMType::class, $PAM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Modificar PAM: '.$PAM->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'PAM actualizado!'
            );

            return $this->redirectToRoute('pam_index');
        }

        return $this->render('pam/edit.html.twig', [
            'pam' => $PAM,
            'form' => $form->createView(),
            'url' => 'pam',
            'routes' => ['PAM', 'Editar'],
        ]);
    }


    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/activate", name="pam_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, PAM $PAM): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $PAM->setActivo(true);
        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Activar PAM: '.$PAM->getId());
        $this->getDoctrine()->getManager()->persist($bitacora);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'notice',
            'PAM activado!'
        );
        return $this->redirectToRoute('pam_index');
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/deactivate", name="pam_deactivate", methods={"GET","POST"})
     */
    public function deactivate(Request $request, PAM $PAM)
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());

        $linea = $PAM->getLineas();

        if (count($linea) > 0)
        {
            $this->addFlash(
                'error',
                'No se puede eliminar este PAM porque está asociado a alguna línea estratégica!'
            );

            return true;
        }
        else
        {
            $PAM->setActivo(false);
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Desactivar PAM: '.$PAM->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'PAM desactivado!'
            );

            return false;
        }
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="pam_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PAM $PAM): Response
    {
        if ($this->isCsrfTokenValid('delete'.$PAM->getId(), $request->request->get('_token'))) {
            if ($this->deactivate($request, $PAM))
            {
                return $this->redirectToRoute('pam_show', array('id'=>$PAM->getId()));
            }
        }

        return $this->redirectToRoute('pam_index');
    }
}