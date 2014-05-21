<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    //	print_r($options['data']);
   /*     $customFields = json_decode($options['data']);
    print_r($customFields);
        
        foreach ($customFields as $key => $customField) {
            $builder->add('field' . $key, 'text', array('mapped' => false));
        }*/
     }

 /*   public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }*/
    
   /* public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }*/
    
    
/*    public function getParent()
    {
        return 'hidden';
    }*/

    /**
     * getName
     */
    public function getName()
    {
        return 'orchestra_customField';
    }
}
