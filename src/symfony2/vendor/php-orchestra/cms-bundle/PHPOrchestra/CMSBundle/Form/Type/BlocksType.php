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
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new JsonToBlocksTransformer($this->documentManager);
        $builder->addModelTransformer($transformer);
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
                'controller' => '',
                'attr' => array('class' => 'not-mapped')
            )
        );
    }
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['controller'] = $options['controller'];
    }
        
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'orchestra_blocks';
    }
}
