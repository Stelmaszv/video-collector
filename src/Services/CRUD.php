<?php
namespace App\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class CRUD extends AbstractController{
    public function create($settings){
        $this->setSetings($settings);
        $form= $this->createForm($this->settings['form'],$this->settings['entity']);
        $form->handleRequest($this->settings['request']);
        $this->form=$form;  
        if($form->isSubmitted() && $form->isValid()){ 
            $this->submit();
            if(isset($settings['header'])){
                return $this->redirectToRoute($this->settings['header']);
            }
        }
        return $this->twing();
    }
    public function reed($array,$paginationinterface,$paginationobj){
        if($array['pagination']){
           return $paginationobj->paginate($array,$paginationinterface);
        }else{
           return $this->show($array,$object);
        }
    }
    public function updata(int $id,$settings){
        $this->setSetings($settings);
        $entity = $this->getDoctrine()->getRepository($this->settings['entityEdit'])->find($id);
        $this->settings['entity']=$entity;
        $form= $this->createForm($this->settings['form'],$entity);
        $form->handleRequest($this->settings['request']);
        $this->form=$form; 
        if($form->isSubmitted() && $form->isValid()){
            $this->submit();
        }
        return $this->twing();
    }
    public function delete(int $id,string $header,$settings){
        $this->setSetings($settings);
        $entity = $this->getDoctrine()->getRepository($this->settings['repository'])->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entity);
        $entityManager->flush();
        return $this->redirectToRoute($header);
 
    }
    private function setSetings(array $settings){
        $this->settings=$settings;
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
    private function twing(){
        return $this->render($this->settings['templete'], array(
            'froms'      =>  $this->form->createView(),
            'twing'      =>  $this->settings['twing'],
            'item'      =>   $this->settings['entity']
        ));
    } 
    private function submit(){
        $this->upload();
        $em =$this->getDoctrine()->getManager();
        $em->persist($this->settings['entity']);
        $em->flush();
    }
    private function upload(){
        if(isset($this->settings['photoField'])){
            $brochureFile = $this->form[$this->settings['photoField']]->getData();
            if($brochureFile){
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = md5(uniqid()).'.'.$brochureFile->guessExtension();
                try {
                    $brochureFile->move(
                        $this->getParameter($this->settings['uplodUrl']),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $e->getMessage();
                }
                $function = 'set'.ucfirst($this->settings['photoField']);
                $entity=$this->settings['entity'];
                $entity->$function($newFilename);
            }
        }
    }
}