<?php

namespace App\Controller;

use App\Entity\Entidad;
use App\Entity\Objetivo;
use App\Repository\ObjetivoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/objetivo")
 */
class ObjetivoController extends AbstractController
{
    /**
     * @Route("/", name="objetivo_index", methods={"GET"})
     */
    public function index(ObjetivoRepository $objetivoRepository, Request $request): Response
    {
        return $this->render('objetivo/index.html.twig', [
            'objetivos' => $objetivoRepository->findAll(),
            'url' => 'objetivos'
        ]);
    }

    /**
     * @Route("/{id}-2/asign/{entidad}", name="objetivo_second", methods={"GET","POST"})
     */
    public function second(Objetivo $objetivo, Entidad $entidad, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());

        return $this->render('objetivo/show.html.twig', [
            'entidad' => $entidad,
            'objetivo' => $objetivo,
            'sec' => '2',
            'url' => 'objetivos'
        ]);
    }

    /**
     * @Route("/{id}/asign/{entidad}", name="objetivo_show")
     */
    public function show(Objetivo $objetivo, Entidad $entidad, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('path', $request->getPathInfo());

        return $this->render('objetivo/show.html.twig', [
            'entidad' => $entidad,
            'objetivo' => $objetivo,
            'sec' => '1',
            'url' => 'objetivos'
        ]);
    }

    /**
     * @Route("/asignado/{id}", name="objetivo_assign")
     */
    public function assign(Entidad $entidad, ObjetivoRepository $objetivoRepository): Response
    {
        return $this->render('objetivo/index.html.twig', [
            'entidad' => $entidad,
            'objetivos' => $objetivoRepository->findAll(),
            'url' => 'objetivos'
        ]);
    }
}
