<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Flash extends AbstractController
{
    const MESSAGE_TYPE = [
      'Delete' => 'Supprimé avec succès',
      'Update' => 'Mise à jour avec succès',
      'Create' => 'Enregistré avec succès',
      'Denied' => 'Oust! Vous n\'êtes pas autorisé à venir ici!',
    ];

    /**
     * @param string $type
     */
    public function createFlash(string $type)
    {
        return $this->addFlash($type, (string) self::MESSAGE_TYPE[$type]);
    }
}
