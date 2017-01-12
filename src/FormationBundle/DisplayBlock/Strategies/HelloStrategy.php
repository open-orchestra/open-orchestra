<?php

namespace FormationBundle\DisplayBlock\Strategies;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;

/**
 * Class HelloStrategy
 */
class HelloStrategy extends AbstractStrategy
{
    const NAME= 'hello';

    /**
     * @param ReadBlockInterface $block
     *
     * @return bool
     */
    public function support(ReadBlockInterface $block)
    {
        return self::NAME === $block->getComponent();
    }

    /**
     * @param ReadBlockInterface $block
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(ReadBlockInterface $block)
    {
        return $this->render('FormationBundle:Block/Hello:block.html.twig');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param ReadBlockInterface $block
     *
     * @return array
     */
    public function getCacheTags(ReadBlockInterface $block)
    {
        return array();
    }
}