<?php

namespace App\Controller;
use App\Entity\Producent;
use App\Form\PorducentEditType;
use App\Repository\ProducentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EditController extends AbstractController
{
    /**
     * @Route("/edit/{id}", name="editProducent")
     */
    public function editProducent(Request $Request,ProducentRepository $ProducentRepository){
        $Producent= new Producent();
        $item=$ProducentRepository->find($Request->get('id'));
        $settings=[
            'twing'=>'createitems/create.html.twig',
            'SectionName'=>'Edit Producent',
            'header'=> 'showProducents',
            'uplodUrl'=> 'producent_directory'
        ];
        return $this->generateCreateview(PorducentEditType::class,$Producent,$settings,$Request);
 
        
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
