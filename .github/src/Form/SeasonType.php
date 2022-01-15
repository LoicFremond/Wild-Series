<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', IntegerType::class, [
                'label' => 'Numéro',
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Sortie',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'title',
                'multiple' => false,
                'label' => 'Programme'
            ])
            ->add('slug', TextType::class, [
                'required' => false,
                'disabled' => 'disabled'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
