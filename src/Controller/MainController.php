<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProducentRepository;
class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function start(ProducentRepository $ProducentRepository){
        $producents=$ProducentRepository->findAll();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'producents'=>$producents
        ]);
    }
}
