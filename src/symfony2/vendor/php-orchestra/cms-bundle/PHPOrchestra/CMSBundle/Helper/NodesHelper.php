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
        foreach ($nodes as $node) {
            $parentId = $node->getParentId();
            if (empty($parentId)) {
                $parentId = Node::ROOT_NODE_ID;
            }
            $links[$parentId][] = array('id' => $node->getNodeId(), 'class' => '', 'text' => $node->getName());
        }
        return NodesHelper::createRecTree($links, $links[Node::ROOT_NODE_ID]);
    }
    public static function createRecTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['sublinks'] = NodesHelper::createRecTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }

        return $tree;
    }
}
