<?php
namespace App\Controller;
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
use App\Controller\AbstractnavigationController;
use App\Services\Settings\moviesSettings;
class MovieController extends AbstractnavigationController{
    const moviestemplete='navigation/showmovies.htm.twig';
    const createtemplete='createitems/create.html.twig';
    const upload='series_directory';
    function __construct(MoviesRepository $MoviesRepository,CRUD $CRUD,PaginatorInterface $paginator,Pagination $Pagination){
        $this->paginator=$paginator;
        $this->pagination=$Pagination;
        $this->setings['createtemplete']=self::createtemplete;
        $this->setings['itemtemolate']=self::itemtemolate;
        $this->setings['createForm']=MoviesType::class;
        $this->setings['EditForm']=MoviesType::class;
        $this->setings['entity']=new Movies;
        $this->setings['upload']=self::upload;
        $this->setings['EditForm']=MoviesType::class;
        $this->setings['Form']=Movies::class;
        $this->setings['Repository']=$MoviesRepository;
        $this->CRUD=$CRUD;
        parent::__construct(new moviesSettings($this->setings)); 
    }
    /**
    * @Route("/editMovies/{id}", name="editMovies")
    */
    public function editMovies(Request $request, $id){
        return $this->updata($id,$request);
    }
    /**
     * @Route("/show_movie/{id}", name="show_movie")
     */
    public function show_movie(Request $Request){
        $item=$this->setings['Repository']->find($Request->get('id'));
        $em=$this->getDoctrine()->getManager();
        $this->setings['Repository']->updateViews($item,$em);
        $TagsArgumsnts=[
            'item'=>$item,
            'getName'=>'Tags'
        ];
        $MoviesArgumsnts=[
            'item'=>$item,
            'getName'=>'Stars'
        ];
        $tags=$this->setings['Repository']->getCollectionInEntity($TagsArgumsnts);
        $stars=$this->setings['Repository']->getCollectionInEntity($MoviesArgumsnts);
        $stars_in_movies=$this->setings['Repository']->getMoviesWithStars($item,$stars,$Request->get('id'));
        $tags_in_movies=$this->setings['Repository']->getMoviesWithTags($item,$tags,$Request->get('id'));
        $movies_in_series=$this->setings['Repository']->getMoviesInSeries($item,$Request->get('id'));

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
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('templete',self::moviestemplete);
        $this->setsetings->setValue('function','searchinRepository');
        $this->setsetings->setValue('functionarguments',[
            'searchvalue'=>$request->get('searchvalue'),
        ]);
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
     * @Route("/", name="main")
     */
    public function showMovies (request $request){
        $this->setsetings->get($request,'reed');
        $this->setsetings->setValue('templete',self::moviestemplete);
        $this->setsetings->setValue('function','Orderby');
        $this->setsetings->setValue('functionarguments',[
            'searchvalue'=>$request->get('searchvalue'),
        ]);
        $data=$this->setsetings->returnSetings();
        return $this->reed($request,$data);
    }
    /**
     * @Route("/deleteMovie/{id}", name="deleteMovie")
     */
    public function deleteMovie($id,request $request){
        return $this->delete($id,'main',$request);
    }
    /**
     * @Route("/CreateMovies", name="CreateMovies")
     */
    public function CreateMovies(request $request){
        $this->setings['entity']->setTime(new \DateTime());
        $this->setings['entity']->setViews(0);
        return $this->create($request);
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
