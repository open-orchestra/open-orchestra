<?php

namespace FormationBundle\GenerateForm;

use OpenOrchestra\Backoffice\GenerateForm\Strategies\AbstractBlockStrategy;
use OpenOrchestra\ModelInterface\Model\BlockInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class HelloBlockFormStrategy extends AbstractBlockStrategy
{
    const BLOCK_NAME = 'hello';

    public function support(BlockInterface $block)
    {
        return $block->getComponent() === HelloBlockFormStrategy::BLOCK_NAME;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
    }

    public function getName()
    {
        return HelloBlockFormStrategy::BLOCK_NAME;
    }

}