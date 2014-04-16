<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateChoiceType extends AbstractType
{

    public $choices = null;

    /**
     * Constructor, require documentLoader service
     * 
     * @param $documentLoader
     */
    public function __construct($documentLoader)
    {
        $templates = $documentLoader->getDocuments('Template', array());
        $this->choices[''] = '--------';
        foreach ($templates as $template) {
            $this->choices[$template->getTemplateId()] = $template->getName();
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => $this->choices,
            )
        );
    }
    
    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'orchestra_template_choice';
    }
}
