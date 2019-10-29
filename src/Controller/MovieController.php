<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;
use App\Repository\MoviesRepository;
use App\Services\CRUD;
use App\Form\MoviesType;
use App\Form\MovieBydirType;
use App\Entity\Movies;
class MovieController extends AbstractController{
    /**
    * @Route("/editMovies/{id}", name="editMovies")
    */
    public function editMovies(Request $request, $id,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'title'=>'Edit Series'
            ]
        ];
        return $CRUD->updata(MoviesType::class,Movies::class,$request,$id,$settings);
    }
    /**
     * @Route("/show_movie/{id}", name="show_movie")
     */
    public function show_movie(Request $Request,MoviesRepository $MoviesRepository){
        $item=$MoviesRepository->find($Request->get('id'));
        $em=$this->getDoctrine()->getManager();
        $MoviesRepository->updateViews($item,$em);
        $TagsArgumsnts=[
            'item'=>$item,
            'getName'=>'Tags'
        ];
        $MoviesArgumsnts=[
            'item'=>$item,
            'getName'=>'Stars'
        ];
        $tags=$MoviesRepository->getCollectionInEntity($TagsArgumsnts);
        $stars=$MoviesRepository->getCollectionInEntity($MoviesArgumsnts);
        $stars_in_movies=$MoviesRepository->getMoviesWithStars($item,$stars,$Request->get('id'));
        $tags_in_movies=$MoviesRepository->getMoviesWithTags($item,$tags,$Request->get('id'));
        $movies_in_series=$MoviesRepository->getMoviesInSeries($item,$Request->get('id'));

        return $this->render('navigation/show_movie.htm.twig', [
            'stars'=>$stars,
            'movie'=>$item,
            'tags' =>$tags,
            'date' =>$item->getTime()->format('d:m:Y:h:m:s'),
            'stars_in_movies' => $stars_in_movies,
            'tags_in_movies'  => $tags_in_movies,
            'movies_in_serie' => $movies_in_series
        ]);
    }
    /**
     * @Route("/faindMovies/{searchvalue}", name="faindMovies")
     */
    public function faindMovies (MoviesRepository $MoviesRepository,CRUD $CRUD,request $request){
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'',
            'sectionName' =>'Movies',
            'url'     =>'show_movie',
            'editLink'=>'editSeries',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'title'       =>'Edit Series',
                'sectionName' =>'Movies',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
        ];
        return $CRUD->reed($MoviesRepository,$array);
    }
    /**
     * @Route("/", name="main")
     */
    public function showMovies (MoviesRepository $MoviesRepository,CRUD $CRUD){
        $array=[
            'function'=>'Orderby',
            'templete'=>'navigation/showmovies.htm.twig',
            'photourl'=>'',
            'sectionName' =>'Movies',
            'url'     =>'show_movie',
            'editLink'=>'editSeries',
            'deleteLink'=>'deleteMovie',
            'twing' => [
                'title'       =>'Edit Series',
                'sectionName' =>'Movies',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
        ];
        return $CRUD->reed($MoviesRepository,$array);
    }
    /**
     * @Route("/deleteMovie/{id}", name="deleteMovie")
     */
    public function deleteMovie($id,CRUD $CRUD){
        return $CRUD->delete($id,Movies::class,'main');
      }
    /**
     * @Route("/CreateMovies", name="CreateMovies")
     */
    public function CreateMovies(request $request,CRUD $CRUD){
        $movies= new Movies();
        $movies->setTime(new \DateTime());
        $movies->setViews(0);
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'twing' => [
                'title'=>'Create Movie'
            ],
            'header'=>'main'
        ];
        return $CRUD->create(MoviesType::class,$movies,$request,$settings);
    }
    /**
     * @Route("/CreateMoviesByDir", name="CreateMoviesByDir")
     */
    public function CreateMoviesByDir(request $request,CRUD $CRUD){
        $movies= new Movies();
        $movies->setTime(new \DateTime());
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'twing' => [
                'title'=>'Create Movie by dir'
            ]
        ];
        $finder = new Finder();
        $form= $this->createForm(MovieBydirType::class,$movies);

        if(isset($_POST['movie_bydir']['save'])){

            $name=$_POST['movie_bydir']['muvieSrc'];
            $url='../'.$name;
            $finder->files()->in($url);

            foreach ($finder as $file) {
                $movies= new Movies();
                // dumps the relative path to the file
                $fileName=$file->getRelativePathname();
                $movies->setTime(new \DateTime());
                $MuvieSrc=$url.'/'.$fileName;
                $movies->setMuvieSrc($MuvieSrc);
                $movies->setName($fileName);
                $movies->setProducent($form['Producent']->getData());
                $movies->setLink(0);
                $em =$this->getDoctrine()->getManager();
                $em->persist($movies);
                $em->flush();
                return $this->redirectToRoute('main');
                
            }
        }
        return $this->render($settings['templete'], array(
            'froms'      => $form->createView(),
            'twing'      => $settings['twing'],
            'item'       => false,
        ));
    }
}
