<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Adapter;

use PHPOrchestra\CMSBundle\Document\DocumentManager;

class SiteAdapter
{
    private $documentManager = null;
    
    /**
     * DocumentManager service constructor
     * 
     * @param DocumentManager $documentManager The documents manager service
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }
	
    public function getLabels()
    {
        return array(
            'Domain',
            'Alias',
            'Default Language',
            'Languages',
            'Blocks');
    }

    public function getSearchs()
    {
        return array(
            array('name' => 'domain', 'type' => 'text'),
            array('name' => 'alias', 'type' => 'text'),
            array('name' => 'defaultLanguage', 'type' => 'text'),
            array('name' => 'languages', 'type' => 'text'),
            array('name' => 'blocks', 'type' => 'text'));
    }
    
    public function getValues($start, $end, $criteria, $sort)
    {
    	$sort = (is_array($sort)) ? array_map('intval', $sort) : $sort;
    	parse_str($criteria, $criteria);
        $collection = $this->documentManager->getDocuments('Site', $criteria, $sort);
        $aValues = array();
        
        foreach ($collection as $item) {
	        $aValues[] = array(
	            $item->getDomain(),
	            $item->getAlias(),
	            $item->getDefaultLanguage(),
	            implode('<br />', $item->getLanguages()),
	            implode('<br />', $item->getBlocks()));
        }
        return $aValues;
    }
}