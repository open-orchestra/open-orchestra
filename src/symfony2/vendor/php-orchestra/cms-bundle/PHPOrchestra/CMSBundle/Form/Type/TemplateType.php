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

class TemplateType extends AbstractType
{
    /**
    * container service
    * @var container
    */
    protected $container = null;

    /**
     * Constructor
     * 
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new NodeTypeTransformer($this->container, false);
        $builder->addModelTransformer($transformer);

        $builder
            ->add('templateId', 'hidden')
            ->add('siteId', 'hidden')
            ->add('deleted', 'hidden')
            ->add('version', 'hidden')
            ->add('name', 'text', array('attr' => array('class' => 'used-as-label')))
            ->add('language', 'orchestra_language')
            ->add('status', 'orchestra_status')
            ->add('boDirection', 'orchestra_direction')
            ->add(
                'areas',
                'orchestra_areas',
                array(
                    'controller' => 'PHPOrchestraCMSBundle:Area:form',
                    'parameter' => array('type' => 'template')
                )
            )
            ->add(
                'blocks',
                'orchestra_blocks',
                array(
                    'mapped' => false,
                    'controller' => 'PHPOrchestraCMSBundle:Block:form',
                    'parameter' => array('type' => 'template')
                )
            )
            ->add('save', 'submit', array('attr' => array('class' => 'not-mapped')));
    }
        
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['inDialog'] = $options['inDialog'];
        $view->vars['beginJs'] = $options['beginJs'];
        $view->vars['endJs'] = $options['endJs'];
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
                'inDialog' => false,
                'beginJs' => array(),
                'endJs' => array()
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
        return 'template';
    }
}
