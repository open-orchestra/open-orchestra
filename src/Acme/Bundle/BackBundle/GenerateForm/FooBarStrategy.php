<?php

namespace Acme\Bundle\BackBundle\GenerateForm;

use OpenOrchestra\Backoffice\GenerateForm\Strategies\AbstractBlockStrategy;
use OpenOrchestra\ModelInterface\Model\BlockInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Acme\Bundle\FrontBundle\DisplayBlock\FooBarStrategy as BaseFooBarStrategy;

/**
 * Class FooBarStrategy
 */
class FooBarStrategy extends AbstractBlockStrategy
{
    /**
     * @param BlockInterface $block
     *
     * @return bool
     */
    public function support(BlockInterface $block)
    {
        return BaseFooBarStrategy::NAME === $block->getComponent();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'foo_bar';
    }
}
