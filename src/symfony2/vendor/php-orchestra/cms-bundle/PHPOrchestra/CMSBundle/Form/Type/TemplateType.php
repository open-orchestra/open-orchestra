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
            ->add('boDirection', 'orchestra_direction')
            ->add('templateId', 'hidden')
            ->add('areas', 'orchestra_areas', array('dialogPath' => $options['dialogPath'], 'attr' => array('class' => 'not-mapped')))
            ->add('blocks', 'orchestra_blocks', array('dialogPath' => $options['dialogPath'], 'attr' => array('class' => 'not-mapped')))
            ->add('save', 'submit');
            ;
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['dialogPath'] = $options['dialogPath'];
    }
    
    /**
     * 
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'dialogPath' => ''
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