<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producent;
use App\Entity\Tags;
use App\Entity\Series;
use App\Form\PorducentEditType;
use App\Form\TagsType;
use App\Form\SeriesType;
use Symfony\Component\HttpFoundation\Request;

class CreateitemsController extends AbstractController{
    /**
     * @Route("/CreateSeries", name="CreateSeries")
     */
    public function CreateSeries(request $request){
        $news= new Series();
        $news->setAvatar('fqef');
        $form= $this->createForm(SeriesType::class,$news);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em =$this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
        }
        return $this->render('createitems/create.html.twig', [
            'controller_name' => 'NewsController',
            'froms'=> $form->createView()
        ]);
    }
    /**
     * @Route("/CreateTags", name="CreateTags")
     */
    public function CreateTags(Request $Request){
        $settings=[
            'twing'=>'createitems/create.html.twig',
            'SectionName'=>'Create Tags',
            'header'=> 'showCategory',
            'uplodUrl'=> 'tag_directory'
        ];
        return $this->generateCreateview(TagsType::class, new Tags(),$settings,$Request);
    }
    /**
     * @Route("/createProducent", name="createProducent")
     */
    public function CreateProducent(Request $Request){
        $settings=[
            'twing'=>'createitems/create.html.twig',
            'SectionName'=>'Create Producent',
            'header'=> 'showProducents',
            'uplodUrl'=> 'producent_directory'
        ];
        return $this->generateCreateview(PorducentEditType::class, new Producent(),$settings,$Request);
    }
    /**
     * @Route("/CreateTest", name="CreateTest")
     */
    public function CreateTest(Request $Request){
        $series = new Series();
        $form= $this->createForm($series,SeriesType::class);
        $form->handleRequest();
        if($form->isSubmitted()){
            $em->$this->getDoctrine()->getManager();
            $em->persist($series);
            $em->flush();
        }
        return $this->render('createitems/create.html.twig', [
            'froms'=> $form->createView(),
            'SectionName'=>$settings['SectionName']
        ]);
        
    }
    private function generateCreateview($form,$Entity,$settings,$reguest){
        $form= $this->createForm($form,$Entity);
        $form->handleRequest($reguest);
        if($form->isSubmitted() && $form->isValid()){
            $brochureFile = $form['avatar']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = md5(uniqid()).'.'.$brochureFile->guessExtension();
                try {
                    $brochureFile->move(
                        $this->getParameter($settings['uplodUrl']),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $e->getMessage();
                }
                $Entity->setAvatar($newFilename);
            }
            $em =$this->getDoctrine()->getManager();
            $em->persist($Entity);
            $em->flush();
            return $this->redirect($this->generateUrl($settings['header']));
        }
        return $this->render($settings['twing'], [
            'froms'=> $form->createView(),
            'SectionName'=>$settings['SectionName']
        ]);
    }
}
