<?php
/**
 * Created by PhpStorm.
 * User: arian
 * Date: 3/noviembre/2022
 * Time: 12:36 PM
 */

namespace App\Controller;

use App\Entity\LineaEstrategica;
use App\Entity\Log;
use App\Form\LineaEstrategicaType;
use App\Repository\LineaEstrategicaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/pam/lineaestrategica")
 */
class LineaEstrategicaController extends AbstractController
{
    /**
     * @Route("/", name="linea_index", methods={"GET"})
     */
    public function index(LineaEstrategicaRepository $lineaEstrategicaRepository, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        return $this->render('pam/linea/index.html.twig', [
            'lineas' => $lineaEstrategicaRepository->findAll(),
            'url' => 'pam',
            'routes' => ['PAM', 'Líneas Estratégicas'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/new", name="linea_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $lineaEstrategica = new LineaEstrategica();

        $form = $this->createForm(LineaEstrategicaType::class, $lineaEstrategica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Insertar línea estratégica');
            $entityManager->persist($bitacora);
            $entityManager->persist($lineaEstrategica);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Línea estratégica registrado!'
            );
            return $this->redirectToRoute('linea_index');
        }

        return $this->render('pam/linea/new.html.twig', [
            'linea' => $lineaEstrategica,
            'form' => $form->createView(),
            'url' => 'pam',
            'routes' => ['PAM', 'Línea Estratégica', 'Nueva'],
        ]);
    }

    /**
     * @Route("/{id}", name="linea_show", methods={"GET"})
     */
    public function show(LineaEstrategica $lineaEstrategica, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        return $this->render('pam/linea/show.html.twig', [
            'linea' => $lineaEstrategica,
            'url' => 'pam',
            'routes' => ['PAM', 'Línea Estratégica', 'Ver'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="linea_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LineaEstrategica $lineaEstrategica): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $form = $this->createForm(LineaEstrategicaType::class, $lineaEstrategica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Modificar línea estratégica: '.$lineaEstrategica->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'Línea estratégica actualizada!'
            );

            return $this->redirectToRoute('linea_index');
        }

        return $this->render('pam/linea/edit.html.twig', [
            'linea' => $lineaEstrategica,
            'form' => $form->createView(),
            'url' => 'pam',
            'routes' => ['PAM', 'Línea Estratégica', 'Editar'],
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/activate", name="linea_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, LineaEstrategica $lineaEstrategica): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $lineaEstrategica->setActivo(true);
        $bitacora = new Log();
        $bitacora->setFecha(new \DateTime('now'))
            ->setUsuario($this->getUser())
            ->setIp($request->getClientIp())
            ->setAccion('Activar línea estratégica: '.$lineaEstrategica->getId());
        $this->getDoctrine()->getManager()->persist($bitacora);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(
            'notice',
            'Línea estratégica activada!'
        );
        return $this->redirectToRoute('linea_index');
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}/deactivate", name="linea_deactivate", methods={"GET","POST"})
     */
    public function deactivate(Request $request, LineaEstrategica $lineaEstrategica)
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());

        $accionPam = $lineaEstrategica->getAcciones();

        if (count($accionPam) > 0)
        {
            $this->addFlash(
                'error',
                'No se puede eliminar esta línea estratégica porque está asociada a alguna acción!'
            );

            return true;
        }
        else
        {
            $lineaEstrategica->setActivo(false);
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Desactivar línea estratégica: '.$lineaEstrategica->getId());
            $this->getDoctrine()->getManager()->persist($bitacora);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'Línea estratégica desactivada!'
            );

            return false;
        }
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="linea_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LineaEstrategica $lineaEstrategica): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineaEstrategica->getId(), $request->request->get('_token'))) {
            if ($this->deactivate($request, $lineaEstrategica))
            {
                return $this->redirectToRoute('linea_show', array('id'=>$lineaEstrategica->getId()));
            }
        }

        return $this->redirectToRoute('linea_index');
    }
}