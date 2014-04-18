<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Helper;

use Model\PHPOrchestraCMSBundle\Node;

class NodesHelper
{
    public static function createTree($nodes)
    {
        $links = array();
        $superRoot = '';
        foreach ($nodes as $node) {
            $nodeId = $node['_id'];
            $parentId = $node['parentId'];
            
            if (Node::ROOT_NODE_ID == $nodeId) {
                $superRoot = $parentId;
            }
            $links[$parentId][] = array('id' => $nodeId, 'class' => '', 'text' => $node['name']);
        }
        
        return NodesHelper::createRecTree($links, $links[$superRoot]);
    }
    
    
    public static function createRecTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $l) {
            if (isset($list[$l['id']])) {
                $l['sublinks'] = NodesHelper::createRecTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        
        return $tree;
    }
}
