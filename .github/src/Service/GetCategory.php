<?php


namespace App\Service;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetCategory extends AbstractController
{
    /**
     * @return array
     */
    public function getCategory():array
    {
        return $this->getDoctrine()->getRepository(Category::class)->findAll();
    }
}
