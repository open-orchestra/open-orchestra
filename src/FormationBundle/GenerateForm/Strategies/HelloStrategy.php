<?php

namespace FormationBundle\GenerateForm\Strategies;

use OpenOrchestra\Backoffice\GenerateForm\Strategies\AbstractBlockStrategy;
use OpenOrchestra\ModelInterface\Model\BlockInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class HelloStrategy
 */
class HelloStrategy extends AbstractBlockStrategy
{
    /**
     * @param BlockInterface $block
     * @return boolean
     */
    public function support(BlockInterface $block)
    {
        return \FormationBundle\DisplayBlock\Strategies\HelloStrategy::NAME === $block->getComponent();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return \FormationBundle\DisplayBlock\Strategies\HelloStrategy::NAME;
    }
}