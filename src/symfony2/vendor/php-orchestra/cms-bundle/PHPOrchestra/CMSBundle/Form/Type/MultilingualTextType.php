<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use PHPOrchestra\CMSBundle\Form\DataTransformer\MultilingualTextTransformer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MultilingualTextType extends AbstractType
{
    private $languages = array();

    /**
     * Constructor
     * 
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $availableLanguages = $container->getParameter('php_orchestra.languages.availables');
        foreach ($availableLanguages as $language) {
            $this->languages[$language] = '';
        }
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new MultilingualTextTransformer($this->languages);
        $builder->addModelTransformer($transformer);
        
        if (isset($options['data'])) {
            $contributedLanguages = (array) json_decode($options['data']);
            
            foreach ($contributedLanguages as $language => $name) {
                if (isset($this->languages[$language])) {
                    $this->languages[$language] = $name;
                }
            }
        }
        
        foreach ($this->languages as $language => $name) {
            $builder->add('language_' . $language, 'text');
        }
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'multilingualText';
    }
}
