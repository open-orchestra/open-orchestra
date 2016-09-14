<?php

namespace FormationBundle\DisplayIcon;

use FormationBundle\GenerateForm\HelloBlockFormStrategy;
use OpenOrchestra\Backoffice\DisplayIcon\Strategies\AbstractStrategy;

class HelloBlockDisplayIconStrategy extends AbstractStrategy
{
    public function support($block)
    {
        return $block === HelloBlockFormStrategy::BLOCK_NAME;
    }

    public function show()
    {
        return 'hello';
    }

    public function getName()
    {
        return HelloBlockFormStrategy::BLOCK_NAME;
    }

}