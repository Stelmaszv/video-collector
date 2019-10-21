<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MoviesRepository;

class MovieController extends AbstractController
{
    /**
     * @Route("/show_movie/{id}", name="show_movie")
     */
    public function show_movie(Request $Request,MoviesRepository $MoviesRepository){
        $item=$MoviesRepository->find($Request->get('id'));
        return $this->render('movie/index.html.twig', [
            'movie'=>$item
        ]);
    }
}
