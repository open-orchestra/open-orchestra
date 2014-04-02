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
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToAreasTransformer;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use mandango;

class TemplateChoiceType extends AbstractType
{

    var $choices = null;

    /**
     * Constructor, require mandango service
     * 
     * @param Mandango\Mandango $mandango
     */
    public function __construct(Mandango\Mandango $mandango = null)
    {
    	$templates = DocumentLoader::getDocuments('Template', array(), $mandango);
    	$this->choices[''] = '--------';
        foreach($templates as $key => $template){
            $this->choices[$template->getTemplateId()] = $template->getName();
        }
    }
	
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->choices,
        ));
    }
    
    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'orchestra_template';
    }
    
}