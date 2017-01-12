<?php

namespace FormationBundle\DisplayIcon\Strategies;

use OpenOrchestra\Backoffice\DisplayIcon\Strategies\AbstractStrategy;

/**
 * Class HelloStrategy
 */
class HelloStrategy extends AbstractStrategy
{
    /**
     * @param string $block
     * @return bool
     */
    public function support($block)
    {
        return \FormationBundle\DisplayBlock\Strategies\HelloStrategy::NAME === $block;
    }

    /**
     * @return string
     */
    public function show()
    {
        return $this->render('FormationBundle:Block/Hello:icon.html.twig');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return \FormationBundle\DisplayBlock\Strategies\HelloStrategy::NAME;
    }
}