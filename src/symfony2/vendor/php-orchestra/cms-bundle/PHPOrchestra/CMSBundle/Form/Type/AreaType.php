<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AreaType extends AbstractType
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
            ->add('areaId', 'text', array('attr' => array('class' => 'used-as-label')))
            ->add('classes', 'text')
            ->add('boDirection', 'choice', array(
                    'choices'   => array('h' => 'Horizontal', 'v' => 'Vertical')));
    }
        
    /**
     * Add parameters to view
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['inDialog'] = $options['inDialog'];
        $view->vars['subForm'] = $options['subForm'];
        $view->vars['beginJs'] = $options['beginJs'];
        $view->vars['endJs'] = $options['endJs'];
    }
    
    /**
     * @param array $options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'inDialog' => false,
                'subForm' => false,
                'beginJs' => array(),
                'endJs' => array()
            )
        );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'areas';
    }
}
