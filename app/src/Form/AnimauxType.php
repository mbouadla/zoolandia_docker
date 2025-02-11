<?php

// src/Form/AnimauxType.php

namespace App\Form;

use App\Entity\Animaux;
use App\Entity\Habitat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnimauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_animal')
            ->add('espece')
            ->add('description')
            ->add('image_animal')
            ->add('poids')
            ->add('age')
            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'type', // Utilise la propriété 'type' pour afficher l'habitat
                'placeholder' => 'Choisir un habitat',
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animaux::class,
        ]);
    }
}
