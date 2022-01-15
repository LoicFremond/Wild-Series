<?php


namespace App\Controller;


use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @param Slugify $slugify
     * @return Response
     */
    public function index(Slugify $slugify) :Response
    {
        return $this->render('wild/home.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/wild/show/{slug}",
     *     requirements={"slug"="[a-z0-9-]+"},
     *     name="wild_show")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug = ''): Response
    {
        return $this->render('wild/show.html.twig', [
            'slug' => $slug
        ]);
    }
}
