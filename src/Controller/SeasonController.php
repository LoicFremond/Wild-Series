<?php

namespace App\Controller;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use App\Service\GetCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property array category
 * @Route("/season")
 */
class SeasonController extends AbstractController
{

    public function __construct(GetCategory $category)
    {
        $this->category = $category->getCategory();
    }

    /**
     * @Route("/", name="season_index", methods={"GET"})
     * @param SeasonRepository $seasonRepository
     * @return Response
     */
    public function index(SeasonRepository $seasonRepository): Response
    {
        return $this->render('admin/season/index.html.twig', [
            'seasons' => $seasonRepository->findAll(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/new", name="season_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($season);
            $entityManager->flush();

            return $this->redirectToRoute('season_index');
        }

        return $this->render('admin/season/new.html.twig', [
            'season' => $season,
            'form' => $form->createView(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}", name="season_show", methods={"GET"})
     * @param Season $season
     * @return Response
     */
    public function show(Season $season): Response
    {
        return $this->render('admin/season/show.html.twig', [
            'season' => $season,
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="season_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Season  $season
     * @return Response
     */
    public function edit(Request $request, Season $season): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('season_index');
        }

        return $this->render('admin/season/edit.html.twig', [
            'season' => $season,
            'form' => $form->createView(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}", name="season_delete", methods={"DELETE"})
     * @param Request $request
     * @param Season  $season
     * @return Response
     */
    public function delete(Request $request, Season $season): Response
    {
        if ($this->isCsrfTokenValid('delete'.$season->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($season);
            $entityManager->flush();
        }

        return $this->redirectToRoute('season_index');
    }
}
