<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LanguageController extends Controller
{
    public function SetLanguageAction($language)
    {
        $contextManager = $this->container->get('phporchestra_cms.contextmanager');
        
        $contextManager->setCurrentLocale($language);
        
        return new JsonResponse(array('success' => true));
    }
}
