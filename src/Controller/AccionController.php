<?php

namespace App\Controller;

use App\Entity\Accion;
use App\Entity\Entidad;
use App\Entity\Log;
use App\Entity\ObjetivoEntidad;
use App\Form\AccionType;
use App\Form\ObjetivoEntidadType;
use App\Repository\ObjetivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/accion")
 */
class AccionController extends AbstractController
{
    /**
     * @Route("/", name="accion_index")
     */
    public function index(): Response
    {
        return $this->render('accion/index.html.twig', [
            'controller_name' => 'AccionController',
            'url' => 'accion'
        ]);
    }

    /**
     * @Route("/new/{id}", name="accion_new", methods={"GET","POST"})
     */
    public function new(Entidad $entidad, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $accion = new Accion();
        $form = $this->createForm(AccionType::class, $accion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Insertar acción');
            $entityManager->persist($bitacora);
            $entityManager->persist($accion);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Acción registrada!'
            );
            return $this->redirectToRoute('objetivo_assign',['id' => $entidad->getId()]);
        }

        return $this->render('accion/new.html.twig', [
            'accion' => $accion,
            'entidad' => $entidad,
            'form' => $form->createView(),
            'url' => 'accion',
            'routes' => ['Entidad', 'Acciones', 'Nueva'],
        ]);
    }
}
