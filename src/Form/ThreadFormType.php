<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Threads;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThreadFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('title')
            ->add('description')
            ->add('body')
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'id',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Threads::class,
            'sanitize_html' => true,
        ]);
    }
}