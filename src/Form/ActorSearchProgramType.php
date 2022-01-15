<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ActorSearchProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('searchPField', TextType::class,
        [
            'label' => false,
            'attr' => [
                'placeholder' => 'Rechercher par série',
                'id' => 'inputSearch'
            ]
        ]);
    }
}
