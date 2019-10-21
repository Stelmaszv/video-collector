<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SeriesRepository;
class SeriesController extends AbstractController
{
    /**
     * @Route("/show_movies_in_series/{id}", name="show_movies_in_series")
     */
    public function show_movies_in_series(Request $Request,SeriesRepository $SeriesRepository){
        $list_of_movies_in_series=[];
        $item=$SeriesRepository->find($Request->get('id'));
        $list_of_movies_in_series=$SeriesRepository->list_of_movies_in_series($item);
        return $this->render('series/index.html.twig', [
            'controller_name' => 'SeriesController',
            'series'=>$list_of_movies_in_series
        ]);
    }
}
