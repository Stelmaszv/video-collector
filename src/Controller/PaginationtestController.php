<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\MoviesRepository;
use App\Entity\Movies;
use App\Services\Pagination;

class PaginationtestController extends AbstractController
{
    /**
     * @Route("/paginationtest", name="paginationtest")
     */
    public function index(Request $request,PaginatorInterface $paginator,MoviesRepository $MoviesRepositoryc)
    {
        $settings=[
            'function'           => 'findAll',
            'functionArguments'  => [],
            'Repository'         => $MoviesRepository,
            'request'            => $request,
            'templete'           => 'paginationtest/index.html.twig'
        ];
        return $Pagination->Paginate($settings,$paginator);
    }
}
