<?php

namespace App\Form;

use App\Entity\Clubs;
use App\Entity\Members;
use App\Entity\Teams;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name')
            ->add('first_name')
            ->add('photo', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Profile photo',
            ])
            ->add('birth_date', null, [
                'widget' => 'single_text',
            ])
            ->add('team', EntityType::class, [
                'class' => Teams::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Members::class,
        ]);
    }
}
