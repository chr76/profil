<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Knowledge;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('title', TextType::class, [
            //     'label' => 'Titre',
            // ])
            ->add('activate', CheckboxType::class, [
                'label' => 'Publier',
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'required' => false,
            ])
            // ->add('knowledge', EntityType::class, [
            //     'class' => Knowledge::class,
            //     'choice_label' => 'title',
            //     'label' => 'Connaissance / Compétence',
            //     'expanded' => false,
            //     'multiple' => false,
            //     'required' => false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
