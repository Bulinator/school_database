<?php

namespace App\Form;

use App\Entity\Lecture;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'clearable',
                    'placeholder' => 'Lastname',
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'clearable',
                    'placeholder' => 'Lastname',
                ]
            ])
            ->add('eid', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'clearable',
                    'placeholder' => 'xx.xx.xx-xxx.xx',
                ]
            ])
            ->add('birthdate', DateType::class, [
                'label' => false,
                'html5' => false,
                'widget' => 'single_text',
                'placeholder' => 'Birthdate',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-target' => '#user_birthdate',
                    'data-toggle' => 'datetimepicker',
                    'onkeydown' => 'return false',
                ]
            ])
            ->add('lecture', EntityType::class, [
                'class' => Lecture::class,
                'label' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => true,
                    'multiple' => true,
                    'data-actions-box' => true,
                    'data-style' => 'btn-secondary',
                    'title' => 'Select one or several lectures'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => true,
                'autocomplete' => 'off'
            ]
        ]);
    }
}