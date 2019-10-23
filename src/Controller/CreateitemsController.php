<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Producent;
use App\Entity\Tags;
use App\Entity\Series;
use App\Form\ProducentType;
use App\Form\TagsType;
use App\Form\SeriesType;
use Symfony\Component\HttpFoundation\Request;

class CreateitemsController extends AbstractController{
    /**
     * @Route("/CreateSeries", name="CreateSeries")
     */
    public function CreateSeries(Request $Request){
        $settings=[
            'twing'=>'createitems/create.html.twig',
            'SectionName'=>'Create Series',
            'header'=> 'showSeries',
            'uplodUrl'=> 'series_directory'
        ];
        return $this->generateCreateview(SeriesType::class, new Series(),$settings,$Request);
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
        return $this->generateCreateview(ProducentType::class, new Producent(),$settings,$Request);
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
