<?php

namespace Acme\Bundle\BackBundle\DisplayIcon;

use OpenOrchestra\Backoffice\DisplayIcon\Strategies\AbstractStrategy;
use Acme\Bundle\FrontBundle\DisplayBlock\HelloStrategy as BaseHelloStrategy;

/**
 * Class HelloStrategy
 */
class HelloStrategy extends AbstractStrategy
{
    /**
     * Check if the strategy support this block
     *
     * @param string $block
     *
     * @return boolean
     */
    public function support($block)
    {
        return BaseHelloStrategy::NAME === $block;
    }

    /**
     * Perform the show action for a block
     *
     * @return string
     */
    public function show()
    {
        return $this->render('AcmeBackBundle:Block/Hello:showIcon.html.twig');
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'hello';
    }
}
