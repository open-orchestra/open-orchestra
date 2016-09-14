<?php

namespace FormationBundle\DisplayBlock;

use FormationBundle\GenerateForm\HelloBlockFormStrategy;
use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;

class HelloBlockDisplayStrategy extends AbstractStrategy
{
    public function support(ReadBlockInterface $block)
    {
        return $block->getComponent() === HelloBlockFormStrategy::BLOCK_NAME;
    }

    public function show(ReadBlockInterface $block)
    {
        return $this->render('FormationBundle:Block/Hello:hello_display_block.html.twig', array(
            'name' => $block->getAttribute('name')
        ));
    }

    public function getName()
    {
        return HelloBlockFormStrategy::BLOCK_NAME;
    }

    public function getCacheTags(ReadBlockInterface $block)
    {
        return array();
    }
}