<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Helper;

use Model\PHPOrchestraCMSBundle\Template;
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToAreasTransformer;
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToBlocksTransformer;
use Mandango;

class TemplateHelper
{
    public static function formatTemplate(Template $template, Mandango\Mandango $mandango)
    {
    	$areaTransformer = new jsonToAreasTransformer();
    	$blockTransformer = new jsonToBlocksTransformer($mandango);
    	
        return array('areas' => $areaTransformer->transform($template->getAreas()),
            'blocks' => $blockTransformer->transform($template->getBlocks()));
    }
}
