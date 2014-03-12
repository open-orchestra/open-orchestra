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
            ->add('name', 'text')
            ->add('version', 'integer')
            ->add('language', 'text')
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