<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\SeasonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('number', NumberType::class, ['label' => 'Episode'])
            ->add('synopsis', TextareaType::class)
            ->add('slug', TextType::class, ['required' => false])
            ->add('poster', TextType::class,
                [
                    'label' => 'Affiche',
                    'attr' => ['class' => 'watch-js'],
                ])
            ->add('season', EntityType::class, [
                'class' => Season::class,
                'choice_label' => 'getSelectFormString',
                'multiple' => false,
                'label' => 'Saison',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
