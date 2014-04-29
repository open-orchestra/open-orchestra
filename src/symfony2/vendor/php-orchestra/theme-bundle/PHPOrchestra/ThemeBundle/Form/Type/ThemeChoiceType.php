<?php
/**
 * This file is part of the PHPOrchestra\ThemeBundle.
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\ThemeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ThemeChoiceType extends AbstractType
{

    public $choices = null;

    public function __construct($themes = array())
    {
        foreach ($themes as $theme) {
            $this->choices[$theme['location']] = $theme['name'];
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => $this->choices
            )
        );
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'orchestra_theme_choice';
    }
}
