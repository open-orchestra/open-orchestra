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
use PHPOrchestra\CMSBundle\Form\DataTransformer\JsonToBlocksTransformer;

class BlocksType extends AbstractType
{
    /**
     * documentManager service
     * @var documentManager
     */
    protected $documentManager = null;

    
    /**
     * Constructor, require documentManager service
     * 
     * @param $documentManager
     */
    public function __construct($documentManager)
    {
        $this->documentManager = $documentManager;
    }
    
    
    /**
     * Form builder
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new JsonToBlocksTransformer($this->documentManager);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'controller' => '',
                'attr' => array('class' => 'not-mapped')
            )
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['controller'] = $options['controller'];
    }
        
    /**
     * Extends textarea type
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * getName
     */
    public function getName()
    {
        return 'orchestra_blocks';
    }
}
