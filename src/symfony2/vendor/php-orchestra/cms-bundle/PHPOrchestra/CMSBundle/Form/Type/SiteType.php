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

class SiteType extends AbstractType
{
    /**
     * @var Router
     */
    private $router;
    
    /**
     * @var Blocks
     */
    private $blocks;
    
    
    /**
     * @param Router
     */
    public function __construct(Router $router, $blocks)
    {
        $this->router = $router;
        $this->blocks = $blocks;
    }
	    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$nameBlocks = 'blocks';
    	
    	$builder
            ->add('siteId', 'hidden')
            ->add('domain', 'text', array('label' => 'Domain'))
            ->add('alias', 'text', array('label' => 'Alias'))
            ->add('defaultLanguage', 'orchestra_language', array('label' => 'Default Language'))
            ->add('languages', 'orchestra_language', array('label' => 'Languages', 'multiple' => true));
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
        $view->vars['showDialog'] = $options['showDialog'];
        $view->vars['objects'] = $options['objects'];
        $view->vars['js'] = $options['js'];
    }
    
    /**
     * @param array $options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'showDialog' => false,
                'js' => array(),
                'objects' => array()
            )
        );
    }

    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('domain', new NotBlank());
    }
    
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'site';
    }
}
