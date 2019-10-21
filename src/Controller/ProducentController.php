<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProducentRepository;

class ProducentController extends AbstractController
{
/**
     * @Route("/show_series_in_producent/{id}", name="show_series_in_producent")
     */
    public function show_series_in_producent(Request $Request,ProducentRepository $ProducentRepository){
        $item=$ProducentRepository->find($Request->get('id'));
        $list_of_movies_in_series=$ProducentRepository->list_of_series_in_producent($item);
        return $this->render('series/index.html.twig', [
            'controller_name' => 'SeriesController',
            'series'=>$list_of_movies_in_series
        ]);
    }
}
