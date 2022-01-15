<?php


namespace App\Service;

use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetEpisode extends AbstractController
{
    /**
     * @return array
     */
    public function getEpisode():array
    {
        return $this->getDoctrine()->getRepository(Episode::class)->findAll();
    }
}