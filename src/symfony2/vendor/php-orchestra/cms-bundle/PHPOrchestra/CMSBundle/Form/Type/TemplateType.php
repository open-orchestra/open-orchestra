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
use Symfony\Component\Routing\Router;

class TemplateType extends AbstractType
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
    
    /**
     * Build Template form
     * 
     * @param FormBuilderInterface $builder
     * @param  array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $nameBlocks = 'blocks';
        
        $builder
            ->add('templateId', 'hidden')
            ->add('siteId', 'hidden')
            ->add('version', 'hidden')
            ->add('name', 'text', array('attr' => array('class' => 'used-as-label')))
            ->add('language', 'orchestra_language')
            ->add('status', 'orchestra_status')
            ->add('boDirection', 'orchestra_direction')
            ->add('areas', 'orchestra_areas', array(
                'dialogPath' => 'PHPOrchestraCMSBundle:Form:area.html.twig',
                'objects' => array('areas', 'blocks')
            ))
            ->add($nameBlocks, 'orchestra_blocks', array(
                'js' => array(
                    'script' => 'local/blocks_template.js',
                    'parameter' => array(
                        'name' => $nameBlocks,
                        'urlNode' => $this->router->generate('php_orchestra_ajax_show_all_nodes'),
                        'urlBlock' => $this->router->generate('php_orchestra_ajax_show_blocks_from_node')
                    ),
                    'render' => array(
                        'blocks' => array(
                            'twig' => 'PHPOrchestraCMSBundle:Blocks:showAllBlocks.html.twig',
                            'parameter' => array('blocks' => $this->blocks, 'prefix' => $nameBlocks.'_')
                        )
                    )
                )
            ))
            ->add('save', 'submit');
            ;
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
        $resolver->setDefaults(array(
            'showDialog' => true,
            'js' => array(),
            'objects' => array('areas')
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
