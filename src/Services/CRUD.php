<?php
namespace App\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class CRUD extends AbstractController{
    public function create($form,$entity,object $request,$settings=false){
        $form= $this->createForm($form,$entity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->submit($form,$entity,$settings);
            if(isset($settings['header'])){
                return $this->redirectToRoute($settings['header']);
            }
        }
        return $this->twing($form,$settings);
    }
    public function reed($array,$paginationinterface,$paginationobj){
        if(isset($array['pagination'])){
           return $paginationobj->paginate($array,$paginationinterface);
        }else{
           return $this->show($array,$object);
        }
    }

    public function updata($form,$entity,object $request,int $id,$settings=false){
        $entity = $this->getDoctrine()->getRepository($entity)->find($id);
        $form= $this->createForm($form,$entity);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->submit($form,$entity,$settings);
        }
        return $this->twing($form,$settings,$entity);
    }
    public function delete(int $id,$obj,string $header){
        $entity = $this->getDoctrine()->getRepository($obj)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entity);
        $entityManager->flush();
        return $this->redirectToRoute($header);
        
    }
    private function show($obj,$array){
        $function=$array['function'];
        if(!isset($array['functionarguments'])){
            $items=$obj->$function();
        }else{
            if(isset($array['id'])){
                $item=$obj->find($array['id']);
                $array['functionarguments']['item']=$item;
            }
            $items=$obj->$function($array['functionarguments']);
        }
        return $this->twing(false,$array,$items); 
    }
    private function twing($form,$settings,$entity=false){
        if($form){
            $form=$form->createView();
        }else{
            $form=$form;
        }
        return $this->render($settings['templete'], array(
            'froms'      => $form,
            'twing'      => $settings['twing'],
            'item'      => $entity
        ));
    } 
    private function submit($form,$entity,$settings){
        $this->upload($form,$entity,$settings);
        $em =$this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }
    private function upload($form,$entity,$settings){
        if(isset($settings['photoField'])){
            $brochureFile = $form[$settings['photoField']]->getData();
            if($brochureFile){
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
                $function = 'set'.ucfirst($settings['photoField']);
                $entity->$function($newFilename);
            }
        }
    }

}