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

class NodeType extends AbstractType
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
     * Constructor
     * 
     * @param $router
     * @param $blocks
     */
    public function __construct(Router $router, $blocks)
    {
        $this->router = $router;
        $this->blocks = $blocks;
    }
            
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nodeId', 'hidden')
            ->add('siteId', 'hidden')
            ->add('templateId', 'orchestra_template_choice')
            ->add('name', 'text', array('attr' => array('class' => 'used-as-label')))
            ->add('nodeType', 'choice', array('choices' => array('page' => 'Page simple')))
            ->add('parentId', 'text', array('read_only' => true))
            ->add('path', 'text')
            ->add('alias', 'text')
            ->add('language', 'orchestra_language')
            ->add('status', 'orchestra_status')
/*            ->add(
                'areas',
                'orchestra_areas',
                array(
                    'dialogPath' => 'PHPOrchestraCMSBundle:Form:area.html.twig',
                    'objects' => array('blocks')
                )
            )
            ->add(
                $nameBlocks,
                'orchestra_blocks',
                array(
                    'dialogPath' => 'PHPOrchestraCMSBundle:Form:block.html.twig',
                    'js' => array(
                        'script' => 'local/blocks.js',
                        'parameter' => array(
                            'name' => $nameBlocks,
                            'urlNode' => $this->router->generate('php_orchestra_ajax_show_all_nodes'),
                            'urlBlock' => $this->router->generate('php_orchestra_ajax_show_blocks_from_node')
                        ),
                        'render' => array(
                            'blocks' => array(
                                'twig' => 'PHPOrchestraCMSBundle:Form:blocksInfo.json.twig',
                                'parameter' => array('blocks' => $this->blocks, 'prefix' => $nameBlocks.'_')
                            )
                        )
                    )
                )
            )*/
            ->add('theme', 'orchestra_theme_choice')
            ->add('save', 'submit');
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['inDialog'] = true;
        $view->vars['showDialog'] = $options['showDialog'];
        $view->vars['objects'] = $options['objects'];
        $view->vars['js'] = $options['js'];
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'showDialog' => true,
                'js' => array(
                    'script' => 'local/node.js',
                    'parameter' => array(
                        'name' => $this->getName(),
                        'urlTemplate' => $this->router->generate('php_orchestra_ajax_show_template')
                    )
                ),
                'objects' => array()
            )
        );
    }
        
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'node';
    }
}
