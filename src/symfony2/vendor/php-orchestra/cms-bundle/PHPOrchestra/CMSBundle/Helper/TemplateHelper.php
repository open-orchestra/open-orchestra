<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Helper;

use Model\PHPOrchestraCMSBundle\Template;
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToAreasTransformer;

class TemplateHelper
{
    public static function formatTemplate(Template $template)
    {
    	$transformer = new jsonToAreasTransformer();
        return $transformer->transform($template->getAreas());
    }
}
