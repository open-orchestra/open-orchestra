<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToAreasTransformer;

class AreasType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new jsonToAreasTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'dialogPath' => '',
            'js' => array(),
            'objects' => array(),
            'attr' => array('class' => 'not-mapped')
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['dialogPath'] = $options['dialogPath'];
        $view->vars['js'] = $options['js'];
        $view->vars['objects'] = $options['objects'];
    }
    
    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'orchestra_areas';
    }
    
}