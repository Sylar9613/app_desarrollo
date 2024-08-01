<?php

namespace App\Controller;

use App\Entity\Entidad;
use App\Entity\Log;
use App\Entity\Objetivo;
use App\Entity\ObjetivoEntidad;
use App\Form\ObjetivoEntidadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/objetivo-entidad")
 */
class ObjetivoEntidadController extends AbstractController
{
    /**
     * @Route("/", name="objetivo_entidad_index")
     */
    public function index(): Response
    {
        return $this->render('objetivo_entidad/index.html.twig', [
            'controller_name' => 'ObjetivoEntidadController',
            'url' => 'objetivo-entidad'
        ]);
    }

    /**
     * @Route("/obj/{id}/ent/{entidad}", name="objetivo_entidad_asign", methods={"GET","POST"})
     */
    public function asign(Objetivo $objetivo, Entidad $entidad, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());
        $obj_ent = new ObjetivoEntidad();
        $form = $this->createForm(ObjetivoEntidadType::class, $obj_ent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $obj_ent->setEntidad($entidad);
            $obj_ent->setObjetivo($objetivo);

            $bitacora = new Log();
            $bitacora->setFecha(new \DateTime('now'))
                ->setUsuario($this->getUser())
                ->setIp($request->getClientIp())
                ->setAccion('Insertar objetivo entidad');

            $entityManager->persist($bitacora);

            $entityManager->persist($obj_ent);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Objetivo entidad registrado!'
            );
            return $this->redirectToRoute('objetivo_assign', ['id' => $entidad->getId()]);
        }

        return $this->render('objetivo_entidad/new.html.twig', [
            'obj_ent' => $obj_ent,
            'objetivo' => $objetivo,
            'entidad' => $entidad,
            'form' => $form->createView(),
            'url' => 'objetivo_entidad',
            'routes' => ['Entidad', 'Objetivos', 'Objetivos-Entidad'],
        ]);

        /*return $this->render('objetivo_entidad/index.html.twig', [
            'objetivo' => $objetivo,
            'entidad' => $entidad,
            'controller_name' => 'ObjetivoEntidadController',
            'url' => 'objetivo-entidad'
        ]);*/
    }
}
