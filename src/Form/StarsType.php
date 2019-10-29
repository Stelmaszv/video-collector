<?php

namespace App\Form;

use App\Entity\Stars;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class StarsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('avatar',FileType::class,[
                'mapped' => false,
                'required' => false,
            ])
            ->add('description')
            ->add('movies')
            ->add('series')
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
            'data_class' => Stars::class,
        ]);
    }
}
