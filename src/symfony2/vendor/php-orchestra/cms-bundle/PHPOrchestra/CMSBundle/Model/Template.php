<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Template bundle document.
 */
abstract class Template extends \Model\PHPOrchestraCMSBundle\Base\Template
{
	
    /**
     * Alias to addBlocks as used by symfony standard forms
     * 
     * @param document | document[] $documents
     */
    public function setBlocks($documents)
    {
        return $this->addBlocks($documents);
    }
}