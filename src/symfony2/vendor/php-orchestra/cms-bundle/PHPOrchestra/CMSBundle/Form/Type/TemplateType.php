<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
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
            ->add('siteId', 'hidden')
            ->add('name', 'text')
            ->add('version', 'hidden')
            ->add('language', 'orchestra_language')
            ->add('status', 'orchestra_status')
            ->add('templateId', 'hidden')
            ->add('areas', 'orchestra_areas', array('showDialog' => $options['showDialog']))
            ->add('blocks', 'orchestra_blocks', array('showDialog' => $options['showDialog']));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['showDialog'] = $options['showDialog'];
    }
    
    /**
     * 
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'showDialog' => false
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