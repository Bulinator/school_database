<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Lecture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LectureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'clearable',
                    'placeholder' => 'Lecture name'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => false,
                'choice_label' => 'name',
                'placeholder' => 'Select one category',
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'data-style' => 'btn-secondary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lecture::class,
            'attr' => [
                'novalidate' => true,
                'autocomplete' => 'off'
            ]
        ]);
    }
}