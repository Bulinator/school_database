<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Lecture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lecture', EntityType::class, [
                'class' => Lecture::class,
                'label' => false,
                'choice_label' => 'name',
                'placeholder' => 'Search by lecture',
                'attr' => [
                    'class' => 'selectpicker onChangeSubmit',
                    'data-live-search' => true,
                    'data-style' => 'btn-secondary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'novalidate' => true,
                'autocomplete' => 'off'
            ]
        ]);
    }
}