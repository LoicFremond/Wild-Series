<?php


namespace App\Service;

use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetSeason extends AbstractController
{
    /**
     * @return array
     */
    public function getSeason():array
    {
        return $this->getDoctrine()->getRepository(Season::class)->findAll();
    }
}