<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\GetCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Require ROLE_ADMIN for *every* controller method in this class
 * @IsGranted("ROLE_ADMIN")
 *
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController
{

    /**
     * Require ROLE_ADMIN for *every* controller method in this class
     * @IsGranted("ROLE_ADMIN")
     *
     * @Route("/admin", name="admin")
     * @param GetCategory $category
     * @return Response
     */
    public function index(GetCategory $category): Response
    {
        return $this->render('admin/index.html.twig', [
            'categories' => $category->getCategory(),
        ]);
    }
}
