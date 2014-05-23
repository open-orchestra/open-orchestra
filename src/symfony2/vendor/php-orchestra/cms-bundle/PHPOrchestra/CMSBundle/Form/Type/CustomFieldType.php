<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomFieldType extends AbstractType
{
    protected $availableFields = null;

    public function __construct(ContainerInterface $container)
    {
        $this->availableFields = $container->getParameter('php_orchestra.custom_types');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', 'text')
            ->add('fieldId', 'text')
            ->add('searchable', 'checkbox', array('required' => false));
            
        $parameters = $this->availableFields[$options['data']->type];
        
        foreach ($parameters['options'] as $optionName => $option) {
            $builder->add(
                'option_' . $optionName,
                $option['type'],
                array(
                    'mapped' => false,
                    'label' => $option['label']
                )
            );
        }
            
    }

 /*   public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }*/
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
       // $view->vars['showDialog'] = $options['showDialog'];
        
    }
    
    /**
     * getName
     */
    public function getName()
    {
        return 'orchestra_customField';
    }
}
