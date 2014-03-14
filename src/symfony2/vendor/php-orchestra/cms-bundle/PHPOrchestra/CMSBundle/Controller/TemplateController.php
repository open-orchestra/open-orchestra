<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Classes\Area;
use PHPOrchestra\CMSBundle\Form\Type\NodeType;

class TemplateController extends Controller
{
    
    /**
     * Render the templates form
     * 
     * @param Request $request
     * @return Response
     */
    public function formAction(Request $request)
    {
        $mandango = $this->container->get('mandango');       
        $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node');
        
        $form = $this->createForm(new NodeType(), $node);
        $form->handleRequest($request);
        
        if ($form->isValid())
        {
            $node = $this->setBlocks($form->get('blocks')->getData(), $node);
            $node = $this->setAreas($form->get('areas')->getData(), $node);   

            $node->save();
            
            return $this->redirect($this->generateUrl('php_orchestra_cms_node', array('nodeId' => $node->getNodeId())));
        }
            
        return $this->render('PHPOrchestraCMSBundle:Node:form.html.twig', array(
            'form' => $form->createView(),
        ));    
    }
    

    
    private function setBlocks($blocks, $node)
    {
        $blocks = json_decode($blocks, true);    
            
        if (is_array($blocks))
        {
            $mandango = $this->container->get('mandango'); 
                  
            foreach($blocks as $block) {
                $block = $mandango->create('Model\PHPOrchestraCMSBundle\Block')
                    ->setComponent($block['component'])  
                    ->setAttributes($block['attributes']);
                $node->addBlocks($block);
            }
        }
        
        return $node;
    }
    
    
    private function setAreas($areas, $node)
    {
        $areas = json_decode($areas, true);            
            
        $nodeAreas = array();
        if (is_array($areas))
            foreach($areas as $area) {
                $area = new Area($area);
                $nodeAreas[] = $area->toArray();
            }
        $node->setAreas($nodeAreas);
            
        return $node;
    }
    
}