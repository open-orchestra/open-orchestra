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
use Symfony\Component\Routing\Router;
use PHPOrchestra\CMSBundle\Form\DataTransformer\SiteTypeTransformer;

class SiteType extends AbstractType
{
        
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = (array_key_exists('subblocks', $options['data'])) ? $options['data']['subblocks'] : array();
        
        $builder
            ->add('siteId', 'hidden')
            ->add('domain', 'text', array('label' => 'Domain'))
            ->add('alias', 'text', array('label' => 'Alias'))
            ->add('defaultLanguage', 'orchestra_language', array('label' => 'Default Language'))
            ->add('languages', 'orchestra_language', array('label' => 'Languages', 'multiple' => true))
            ->add('blocks', 'orchestra_block_choice', array('multiple' => true));
    }
    
    /**
     * @param array $options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'refresh' => array()
            )
        );
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'site';
    }
}
