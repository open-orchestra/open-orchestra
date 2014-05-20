<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContentTypeType extends AbstractType
{
    public function __construct()
    {
        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('version', 'text')
            ->add('name', 'text')
            ->add('save', 'submit');
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'contentType';
    }
}
