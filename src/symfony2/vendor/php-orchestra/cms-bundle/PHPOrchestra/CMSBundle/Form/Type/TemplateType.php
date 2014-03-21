<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    
    /**
     * Build Template form
     * 
     * @param FormBuilderInterface $builder
     * @param  array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siteId', 'integer')
            ->add('name', 'text')
            ->add('version', 'integer')
            ->add('language', 'text')
            ->add('status', 'text')
            ->add('templateId', 'integer')
            ->add('areas', 'orchestra_areas', array('dialog' => $options['dialog']))
            ->add('blocks', 'orchestra_blocks')
            ->add('save', 'submit');
    }
    
    /**
     * 
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'dialog' => false
        ));
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'template';
    }
}