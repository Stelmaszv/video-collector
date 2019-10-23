<?php

namespace App\Form;

use App\Entity\Producent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PorducentEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('avatar',FileType::class,[
                'mapped' => false,
                'required' => false,
            ])
            ->add('series', EntityType::class, [
                'class'        => 'App\Entity\Movies',
                'choice_label' => 'name',
                'label'        => 'Series',
                'expanded'     => true,
                'multiple'     => true,
            ])
            ->add('stars',EntityType::class, [
                'class'        => 'App\Entity\Stars',
                'choice_label' => 'name',
                'label'        => 'Stars',
                'expanded'     => true,
                'multiple'     => true,
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
            'data_class' => Producent::class,
        ]);
    }
}