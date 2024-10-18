<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Students;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name')
            ->add('first_name')
            ->add('birth_date', null, [
                'widget' => 'single_text',
            ])
            ->add('class', EntityType::class, [
                'class' => Classes::class,
                'choice_label' => 'name',
                'label' => 'Class',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
