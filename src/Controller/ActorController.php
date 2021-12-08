<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use App\Service\GetCategory;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property array category
 * @Route("/actor")
 */
class ActorController extends AbstractController
{

    public function __construct(GetCategory $category)
    {
        $this->category = $category->getCategory();
    }

    /**
     * @Route("/", name="actor_index", methods={"GET"})
     * @param ActorRepository    $actorRepository
     * @param PaginatorInterface $paginator
     * @param Request            $request
     * @return Response
     */
    public function index(ActorRepository $actorRepository, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('admin/actor/index.html.twig', [
            'actors' => $paginator->paginate(
                $actorRepository->findAll(),
                $request->query->getInt('page', 1),
                15
            ),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/new", name="actor_new", methods={"GET","POST"})
     * @param Request                $request
     * @param Slugify                $slugify
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function new(Request $request, Slugify $slugify, EntityManagerInterface $entityManager): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $actor->setSlug($slugify->generate($actor->getName()));
            $entityManager->persist($actor);
            $entityManager->flush();

            return $this->redirectToRoute('actor_index');
        }

        return $this->render('admin/actor/new.html.twig', [
            'actor' => $actor,
            'form' => $form->createView(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}", name="actor_show", methods={"GET"})
     * @param Actor $actor
     * @return Response
     */
    public function show(Actor $actor): Response
    {
        return $this->render('admin/actor/show.html.twig', [
            'actor' => $actor,
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actor_edit", methods={"GET","POST"})
     * @param Request                $request
     * @param Actor                  $actor
     * @param EntityManagerInterface $entityManager
     * @param Slugify                $slugify
     * @return Response
     */
    public function edit(Request $request, Actor $actor, EntityManagerInterface $entityManager, Slugify $slugify): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager();
            $actor->setSlug($slugify->generate($actor->getName()));
            $entityManager->persist($actor);
            $entityManager->flush();

            return $this->redirectToRoute('actor_index');
        }

        return $this->render('admin/actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form->createView(),
            'categories' => $this->category,
        ]);
    }

    /**
     * @Route("/{id}", name="actor_delete", methods={"DELETE"})
     * @param Request $request
     * @param Actor   $actor
     * @return Response
     */
    public function delete(Request $request, Actor $actor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actor_index');
    }
}
