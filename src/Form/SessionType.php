<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Cours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('heureDebut', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('heureFin', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('salle')
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'module',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
