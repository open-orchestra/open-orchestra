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
use PHPOrchestra\CMSBundle\Helper\NodesHelper;

class NodesController extends Controller
{

    /**
     * List all nodes
     * 
     */
    public function showAllNodesAction(Request $request)
    {
        $form = $this->get('form.factory')
            ->createNamedBuilder($request->get('form'), 'form')
            ->add('nodeId', 'orchestra_node_choice')
            ->getForm();
        $render = $this->render(
            'PHPOrchestraCMSBundle:Form:input.html.twig',
            array(
                'form' => $form->createView()
            )
        );
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => $render->getContent()
                )
            );
        } else {
            return new Response($render->getContent());
        }
    }
    
    /**
     * List all nodes
     * 
     */
    public function showTreeNodesAction(Request $request)
    {
        $nodes = $this->get('phporchestra_cms.documentloader')->getNodesInLastVersion();
        return $this->render(
            'PHPOrchestraCMSBundle:Tree:tree.html.twig',
            array(
                'name' => 'node',
                'path' => 'php_orchestra_cms_nodeform',
                'refresh' => 'rightbox-content',
                'links' => NodesHelper::createTree($nodes)
            )
        );
    }
}
