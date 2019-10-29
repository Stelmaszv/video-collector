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
                
            }
        }
        
        return $this->render($settings['templete'], array(
            'froms'      => $form->createView(),
            'twing'      => $settings['twing'],
            'item'       => false,
        ));


    } 

   /**
     * @Route("/CreateMovies", name="CreateMovies")
     */
    public function CreateMovies(request $request,CRUD $CRUD){
        $movies= new Movies();
        $movies->setTime(new \DateTime());
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'twing' => [
                'title'=>'Create Movie'
            ]
        ];
        return $CRUD->create(MoviesType::class,$movies,$request,$settings);
    }
    /**
     * @Route("/CreateSeries", name="CreateSeries")
     */
    public function CreateSeries(request $request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'series_directory',
            'twing' => [
                'title'=>'Create Series'
            ]
        ];
        return $CRUD->create(SeriesType::class,new Series(),$request,$settings);
    }
    /**
     * @Route("/CreateTags", name="CreateTags")
     */
    public function CreateTags(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'tag_directory',
            'twing' => [
                'title'=>'Create Category'
            ]
        ];
        return $CRUD->create(TagsType::class, new Tags(),$Request,$settings);
    }
    /**
     * @Route("/createProducent", name="createProducent")
     */
    public function CreateProducent(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'producent_directory',
            'twing' => [
                'title'=>'Create Producent'
            ]
        ];
        return $CRUD->create(PorducentEditType::class, new Producent(),$Request,$settings);
    }
        /**
     * @Route("/createStars", name="createStars")
     */
    public function createStars(Request $Request,CRUD $CRUD){
        $settings=[
            'templete'=>'createitems/create.html.twig',
            'photoField'=>'avatar',
            'uplodUrl'=> 'producent_directory',
            'twing' => [
                'title'=>'Create Star'
            ]
        ];
        return $CRUD->create(StarsType::class, new Stars(),$Request,$settings);
    }
}
