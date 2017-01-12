<?php

namespace FormationBundle\BlockParameter\Stategies;

use OpenOrchestra\Backoffice\BlockParameter\BlockParameterInterface;
use OpenOrchestra\ModelInterface\Model\BlockInterface;

/**
 * Class HelloStrategy
 */
class HelloStrategy implements BlockParameterInterface
{
    /**
     * @param BlockInterface $block
     *
     * @return boolean
     */
    public function support(BlockInterface $block)
    {
        return \FormationBundle\DisplayBlock\Strategies\HelloStrategy::NAME === $block->getComponent();
    }

    /**
     * @return array
     */
    public function getBlockParameter()
    {
        return array(
            'request.contentId'
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return \FormationBundle\DisplayBlock\Strategies\HelloStrategy::NAME;
    }
}
