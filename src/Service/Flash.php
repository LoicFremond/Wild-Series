<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Flash extends AbstractController
{
    const MESSAGE_TYPE = [
      'delete' => 'Supprimé avec succès',
      'update' => 'Mise à jour avec succès',
      'create' => 'Enregistré avec succès',
      'denied' => 'Oups! Vous n\'êtes pas autorisé à faire ceci',
    ];

    /**
     * @param string $type
     */
    public function createFlash(string $type)
    {
        return $this->addFlash($type, (string) self::MESSAGE_TYPE[$type]);
    }
}
