<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Helper;

use Model\PHPOrchestraCMSBundle\Node;

class TreeHelper
{
    public static function createTree($values, $l_id = null, $l_pid = null)
    {
        if ($l_id === null) {
            foreach ($values as $key => $value) {
                $values[$key] = array();
                $values[$key]['id'] = $value;
            }
            return $values;
        } else {
            $connection = array();
            foreach ($values as $value) {
                $connection[$value[$l_id]] = $value[$l_pid];
            }
            $links = array();

            $superRoot = '';
            foreach ($connection as $key => $value) {
                $id = $key;
                $pid = $value;
                if (!array_key_exists($pid, $connection)) {
                    $superRoot = $pid;
                }
                $links[$pid][] = array('id' => $id);
            }
            
            $links = TreeHelper::createRecTree($links, $links[$superRoot]);
            
            $connection = array();
            foreach ($values as $value) {
                $connection[$value[$l_id]] = $value;
            }
            array_walk_recursive($links, function (&$value) use ($connection) {
                $value = $connection[$value];
            });
            
            return $links;
        }
    }
    
    
    public static function createRecTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $l) {
            if (isset($list[$l['id']])) {
                $l['sublinks'] = TreeHelper::createRecTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        
        return $tree;
    }
}
