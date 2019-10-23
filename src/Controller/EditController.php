<?php

namespace App\Controller;
use App\Entity\Producent;
use App\Entity\Series;
use App\Form\PorducentEditType;
use App\Form\SeriesType;
use App\Repository\ProducentRepository;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditController extends AbstractController
{
        /**
     * @Route("/edit/{id}", name="editSeries")
     */
    
    public function editSeries(Request $request, $id){
        $article = new Series();
        $article = $this->getDoctrine()->getRepository(Series::class)->find($id);
        $form= $this->createForm(SeriesType::class,$article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
          return $this->redirectToRoute('showSeries');
        }
        return $this->render('createitems/create.html.twig', array(
          'SectionName'=>'Edit series',
          'froms' => $form->createView()
        ));
    }
    /**
     * @Route("/editProducent/{id}", name="editProducent")
     */
    public function editProducent(Request $Request,ProducentRepository $ProducentRepository){
        $Producent= new Producent();
        $item=$ProducentRepository->find($Request->get('id'));
        $settings=[
            'twing'=>'createitems/create.html.twig',
            'SectionName'=>'Edit Producent',
            'header'=> 'showProducents',
            'uplodUrl'=> 'producent_directory',
            'file'=>'avatar'
        ];
        return $this->generateCreateview(PorducentEditType::class,$Producent,$settings,$Request);
    }
    private function generateCreateview($form,$Entity,$settings,$reguest){
        $form= $this->createForm($form,$Entity);
        $form->handleRequest($reguest);
        if($form->isSubmitted() && $form->isValid()){
            if($settings['file']){
                $brochureFile = $form[$settings['file']]->getData();
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
