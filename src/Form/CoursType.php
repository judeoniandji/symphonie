<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Classe;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('module', TextType::class, [
                'label' => 'Module',
            ])
            ->add('professeur', EntityType::class, [
                'class' => Professeur::class,
                'choice_label' => 'nom',
            ])
            ->add('classes', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
