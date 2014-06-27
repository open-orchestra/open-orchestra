<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\Block;

interface BlockInterface
{
    
    /**
     * Render the block for the front
     * 
     */
    public function showAction($parameter);
    /**
     * Render the block for the back
     * 
     */
    public function showBackAction($parameter);
}
