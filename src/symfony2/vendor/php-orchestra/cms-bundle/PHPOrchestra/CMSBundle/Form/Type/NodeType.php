<?php

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NodeType extends AbstractType
{
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
            ->add('structure', 'textarea', array("mapped" => false))
            //            ->add('areas', 'orchestraAreas')
//            ->add('blocks', 'orchestraBlocks')
            ->add('save', 'submit');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Model\PHPOrchestraCMSBundle\Node',
        );
    }
    
    public function getName()
    {
        return 'node';
    }
}