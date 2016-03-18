<?php

namespace OpenOrchestra\ElasticaAdmin\DisplayBlock;

use OpenOrchestra\DisplayBundle\DisplayBlock\Strategies\AbstractStrategy;
use OpenOrchestra\ModelInterface\Model\ReadBlockInterface;
use Symfony\Component\HttpFoundation\Response;
use OpenOrchestra\ElasticaFront\DisplayBlock\ElasticaListStrategy as BaseElasticaListStrategy;

/**
 * Class ElasticaListStrategy
 */
class ElasticaListStrategy extends AbstractStrategy
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
        return BaseElasticaListStrategy::NAME == $block->getComponent();
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
        return 'elastica_list';
    }
}
