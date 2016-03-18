<?php

namespace Acme\Bundle\BackBundle\DisplayBlock;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Acme\Bundle\FrontBundle\DisplayBlock\FooBarStrategy as FooBarStrategyBase;

/**
 * Class FooBarStrategy
 */
class FooBarStrategy extends AbstractStrategy
{
    /**
     * Check if the strategy support this block
     *
     * @param ReadBlockInterface $block
     *
     * @return boolean
     */
    public function support(ReadBlockInterface $block)
    {
        return FooBarStrategyBase::NAME == $block->getComponent();
    }

    /**
     * Perform the show action for a block
     *
     * @param ReadBlockInterface $block
     *
     * @return Response
     */
    public function show(ReadBlockInterface $block)
    {
        return $this->render('OpenOrchestraElasticaAdminBundle:Block/List:show.html.twig', array(
            'id' => $block->getId(),
            'class' => $block->getClass(),
        ));
    }

    /**
     * @param ReadBlockInterface $block
     *
     * @return Array
     */
    public function getCacheTags(ReadBlockInterface $block)
    {
        return array();
    }

    /**
     * Get the name of the strategy
     *
     * @return string
     */
    public function getName()
    {
        return 'foor_bar';
    }
}
