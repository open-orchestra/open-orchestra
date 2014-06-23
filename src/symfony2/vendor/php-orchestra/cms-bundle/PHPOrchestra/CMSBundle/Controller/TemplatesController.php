<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TemplatesController extends Controller
{

    /**
     * List all nodes for tree
     * 
     */
    public function showTreeTemplatesAction(Request $request)
    {
        $templates = $this->get('phporchestra_cms.documentmanager')->getTemplatesInLastVersion();
        $links = array();
        foreach ($templates as $template) {
            $class = '';
            if ($template['deleted'] == true) {
                $class = 'deleted';
            }
            $links[] = array('id' => $template['_id'], 'class' => $class, 'text' => $template['name']);
        }
        return $this->render(
            'PHPOrchestraCMSBundle:Tree:tree.html.twig',
            array(
                'name' => 'Templates',
                'path' => 'php_orchestra_cms_templateform',
                'links' => $links,
                'mode' => 'templates'
            )
        );
    }
}
