<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NodeType extends AbstractType
{
	
    /**
     * Build Node form
     * 
     * @param FormBuilderInterface $builder
     * @param  array $options
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
        $builder
            ->add('nodeId', 'integer')
            ->add('siteId', 'integer')
            ->add('parentId', 'integer')
            ->add('path', 'text')
            ->add('name', 'text')
            ->add('version', 'integer')
            ->add('language', 'text')
            ->add('status', 'text')
            ->add('templateId', 'integer')
            ->add('areas', 'phporchestra_areas')
            ->add('blocks', 'textarea', array("mapped" => false))
            ->add('save', 'submit');
    }
    
    /**
     * @param array $options
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Model\PHPOrchestraCMSBundle\Node',
        );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'node';
    }
}