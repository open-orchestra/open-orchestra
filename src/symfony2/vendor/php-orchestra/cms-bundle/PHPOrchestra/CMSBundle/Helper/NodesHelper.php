<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Helper;

class NodesHelper
{
    public static function formatNodes($nodes)
    {
        foreach($nodes as $key => $node){
            $nodes[$key] = array("nodeId" => $node->getNodeId(), "name" => $node->getName());
        }
        return $nodes;
    }
}
