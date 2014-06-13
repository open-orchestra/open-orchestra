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
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.AbstractType::buildForm()
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
            ->add(
                'areas',
                'orchestra_areas',
                array(
                    'controller' => 'PHPOrchestraCMSBundle:SubForm:Area'
                )
            )
            ->add(
                'blocks',
                'orchestra_blocks',
                array(
                    'controller' => 'PHPOrchestraCMSBundle:SubForm:Block'
                )
            )
            ->add('save', 'submit');
            ;
    }
        
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['inDialog'] = $options['inDialog'];//true
    	$view->vars['js'] = $options['js'];//'pagegenerator/template/begin.js';
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'inDialog' => false,
                'js' => ''
            )
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'template';
    }
}
