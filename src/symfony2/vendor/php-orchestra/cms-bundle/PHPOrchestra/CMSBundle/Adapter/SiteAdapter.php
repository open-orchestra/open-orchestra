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
	
    public function getValues($start, $end, $criteria, $sort)
    {
        $collection = $this->documentManager->getDocuments('Site', $criteria, $sort);
        $aValues = array();
        foreach ($collection as $item) {
            $aValues['domain'] = $item->getDomain();
            $aValues['alias'] = $item->getAlias();
            $aValues['defaultLanguage'] = $item->getDefaultLanguage();
            $aValues['languages'] = $item->getLanguages();
            $aValues['blocks'] = $item->getBlocks();
        }
        var_dump($aValues);
        return $aValues;
    }
}


/*        $templates = $this->get('phporchestra_cms.documentmanager')->getTemplatesInLastVersion();
        $links = array();
        foreach ($templates as $template) {
            $class = '';
            if ($template['deleted'] == true) {
                $class = 'deleted';
            }
            $links[] = array('id' => $template['_id'], 'class' => $class, 'text' => $template['name']);
        }
*/