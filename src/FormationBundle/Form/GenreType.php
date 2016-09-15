<?php

namespace FormationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => array(
                    'M' => 'm',
                    'F' => 'f',
                ),
                'expanded' => true,
            )
        );
    }

    public function getName()
    {
        return "formation_genre_type";
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

}