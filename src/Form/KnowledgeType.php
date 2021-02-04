<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Knowledge;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KnowledgeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $webPath = realpath('../public/img/icons');
        // $finder = new Finder();
        // $finder->in($webPath);
        // $filelist = [];
        // $filelist['(Aucune)'] = '';
        // if ($finder->hasResults()) {
        //     foreach ($finder as $file) {
        //         $filelist[$file->getRelativePathname()] = $file->getRelativePathname();
        //     }
        // }

        $builder
            ->add('title')
            ->add('description')
            // ->add('Icon', ChoiceType::class, [
            //     'choices' => $filelist
            // ])
            ->add('icon', TextType::class, [
                'label' => 'Icône'
            ])
            ->add('domain', ChoiceType::class, [
                'label' => 'Domaine',
                'choices' => [
                    '' => null,
                    'Connaissance' => 'connaissance',
                    'Compétence' => 'competence',
                ]
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'choices' => [
                    '' => null,
                    '★☆☆☆' => 1,
                    '★★☆☆' => 2,
                    '★★★☆' => 3,
                    '★★★★' => 4,
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'expanded' => false,
                'multiple' => false,
                'required' => false,
            ])
            ->add('activate', CheckboxType::class, [
                'label' => 'Publier',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Knowledge::class,
        ]);
    }
}
