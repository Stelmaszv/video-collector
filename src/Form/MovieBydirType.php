<?php

namespace App\Form;

use App\Entity\Movies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MovieBydirType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('movieSrc')
        ->add('tags')
        ->add('cantry')
        ->add('series')
        ->add('Producent', EntityType::class, [
            'class'   => 'App\Entity\Producent',
        ])
        ->add('save',SubmitType::class,[
            'attr'=>[
                'class' =>'btn btn-primary float-right'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
