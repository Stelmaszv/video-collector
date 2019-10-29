<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Entity\Producent;
use App\Entity\Tags;
use App\Entity\Series;
use App\Entity\Movies;
use App\Entity\Stars;
use App\Form\PorducentEditType;
use App\Form\MovieBydirType;
use App\Form\MoviesType;
use App\Form\TagsType;
use App\Form\SeriesType;
use App\Form\StarsType;
use App\Services\CRUD;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;

class CreateitemsController extends AbstractController{
}
