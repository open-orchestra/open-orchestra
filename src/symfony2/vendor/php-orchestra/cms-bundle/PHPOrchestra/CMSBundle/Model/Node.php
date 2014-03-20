<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Node bundle document.
 */
abstract class Node extends \Model\PHPOrchestraCMSBundle\Base\Node
{

    /**
     * Alias to addBlocks as used by symfony standard forms
     * 
     * @param document | document[] $documents
     */
    public function setBlocks($documents)
    {
        $this->addBlocks($documents);
    }
}