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
use PHPOrchestra\CMSBundle\Form\DataTransformer\NodeTypeTransformer;

class NodeType extends AbstractType
{

    /**
    * documentManager service
    * @var documentManager
    */
    protected $documentManager = null;
    
    /**
     * Constructor
     * 
     * @param $router
     * @param $blocks
     */
    public function __construct($documentManager)
    {
        $this->documentManager = $documentManager;
    }
            
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	
        $transformer = new NodeTypeTransformer($this->documentManager);
        $builder->addModelTransformer($transformer);
    	
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
            ->add(
                'areas',
                'orchestra_areas',
                array(
                    'controller' => 'PHPOrchestraCMSBundle:NodeArea:form'
                )
            )
            ->add(
                'blocks',
                'orchestra_blocks',
                array(
                    'mapped' => false,
                    'controller' => 'PHPOrchestraCMSBundle:NodeBlock:form'
                )
            )
            ->add('theme', 'orchestra_theme_choice')
            ->add('save', 'submit');
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['inDialog'] = $options['inDialog'];
        $view->vars['js'] = $options['js'];
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
        return 'node';
    }
}
