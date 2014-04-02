<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Helper;

use Model\PHPOrchestraCMSBundle\Node;

class NodeHelper
{
    public static function filterBlocks(Node $node, $configBlocks)
    {
        foreach($configBlocks as $key => $configBlock){
            $configBlocks[$key] = $configBlock['action'];
        }
        $configBlocks = array_flip($configBlocks);
        $blocks = $node->getBlocks();
        $blocksComponent = array();
        $intRank = 0;
        foreach($blocks as $block){
            $component = $block->getComponent();
            if(array_key_exists($component, $configBlocks)){
               $blocksComponent[] = array('blockId' => $intRank, 'name' => $configBlocks[$component]);
            }
            $intRank++;
        }
        
        return $blocksComponent;
        
    }
}
