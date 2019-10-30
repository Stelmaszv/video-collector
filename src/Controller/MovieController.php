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
use Knp\Component\Pager\PaginatorInterface;
use App\Services\Pagination;
class MovieController extends AbstractController{
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='series_directory';
    function __construct(MoviesRepository $MoviesRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->Repository=$MoviesRepository;
        $this->CRUD=$CRUD;
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->Entity=new Movies;
        $this->CreateForm=MoviesType::class;
        $this->EditForm=MoviesType::class;
        $this->Form=Movies::class;
        $this->createBydir=MovieBydirType::class;
    }
    /**
    * @Route("/editMovies/{id}", name="editMovies")
    */
    public function editMovies(Request $request, $id){
        $settings=[
            'templete'=>  self::createtemplete,
            'uplodUrl'=>  self::upload,
            'twing' => [
                'title'=>'Edit Series'
            ]
        ];
        return $this->CRUD->updata($this->EditForm,$this->Form,$request,$id,$settings);
    }
    /**
     * @Route("/show_movie/{id}", name="show_movie")
     */
    public function show_movie(Request $Request){
        $item=$this->Repository->find($Request->get('id'));
        $em=$this->getDoctrine()->getManager();
        $this->Repository->updateViews($item,$em);
        $TagsArgumsnts=[
            'item'=>$item,
            'getName'=>'Tags'
        ];
        $MoviesArgumsnts=[
            'item'=>$item,
            'getName'=>'Stars'
        ];
        $tags=$this->Repository->getCollectionInEntity($TagsArgumsnts);
        $stars=$this->Repository->getCollectionInEntity($MoviesArgumsnts);
        $stars_in_movies=$this->Repository->getMoviesWithStars($item,$stars,$Request->get('id'));
        $tags_in_movies=$this->Repository->getMoviesWithTags($item,$tags,$Request->get('id'));
        $movies_in_series=$this->Repository->getMoviesInSeries($item,$Request->get('id'));

        return $this->render('navigation/show_movie.htm.twig', [
            'stars'=>$stars,
            'movie'=>$item,
            'tags' =>$tags,
            'stars_in_movies' => $stars_in_movies,
            'tags_in_movies'  => $tags_in_movies,
            'movies_in_serie' => $movies_in_series
        ]);
    }
    /**
     * @Route("/faindMovies/{searchvalue}", name="faindMovies")
     */
    public function faindMovies (request $request){
        $array=[
            'function'=>'searchinRepository',
            'functionarguments'=>[
                'searchvalue'=>$request->get('searchvalue'),
            ],
            'pagination'         => true,
            'Repository'         => $this->Repository,
            'templete'           => self::moviestemplete,
            'photourl'           =>'',
            'request'            => $request,
            'sectionName'        =>'Movies',
            'url'                =>'show_movie',
            'editLink'           =>'editSeries',
            'deleteLink'         =>'deleteMovie',
            'twing'           => [
                'title'       =>'Edit Series',
                'sectionName' =>'Movies',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/", name="main")
     */
    public function showMovies (request $request){
        $array=[
            'function'           => 'Orderby',
            'functionarguments'  => [],
            'pagination'         => true,
            'Repository'         => $this->Repository,
            'request'            => $request,
            'templete'           => self::moviestemplete,
            'twing' => [
                'title'       =>'Edit Series',
                'sectionName' =>'Movies',
                'editLink'    =>'editMovies',
                'deleteLink'  =>'deleteMovie',
                'url'         =>'show_movie',
            ]
        ];
        return $this->CRUD->reed($array,$this->paginator,$this->pagination);
    }
    /**
     * @Route("/deleteMovie/{id}", name="deleteMovie")
     */
    public function deleteMovie($id){
        return $this->CRUD->delete($id,$this->Form,'main');
    }
    /**
     * @Route("/CreateMovies", name="CreateMovies")
     */
    public function CreateMovies(request $request){
        $this->Entity->setTime(new \DateTime());
        $this->Entity->setViews(0);
        $settings=[
            'templete'=>self::createtemplete,
            'twing' => [
                'title'=>'Create Movie'
            ],
            'header'=>'main'
        ];
        return $this->CRUD->create($this->CreateForm,$this->Entity,$request,$settings);
    }
    /**
     * @Route("/CreateMoviesByDir", name="CreateMoviesByDir")
     */
    public function CreateMoviesByDir(request $request){
        $this->Entity->setTime(new \DateTime());
        $this->Entity->setViews(0);
        $settings=[
            'templete'=>self::createtemplete,
            'twing' => [
                'title'=>'Create Movie by dir'
            ]
        ];
        $finder = new Finder();
        $form= $this->createForm($this->createBydir,$this->Entity);

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
