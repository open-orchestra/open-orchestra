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

    /**
     * Constructor
     * 
     * @param $themes
     */
    public function __construct($themes = array())
    {
        foreach ($themes as $themeId => $theme) {
            $this->choices[$themeId] = $theme['name'];
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => $this->choices
            )
        );
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'orchestra_theme_choice';
    }
}
