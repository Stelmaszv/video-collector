<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="deleteProducent")
     */
    public function deleteProducent()
    {
        return $this->render('delete/index.html.twig', [
            'controller_name' => 'DeleteController',
        ]);
    }
}
