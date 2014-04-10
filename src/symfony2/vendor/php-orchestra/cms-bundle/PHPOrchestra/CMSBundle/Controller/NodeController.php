<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Exception\NonExistingDocumentException;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Form\Type\NodeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use PHPOrchestra\CMSBundle\Helper\NodeHelper;
use PHPOrchestra\CMSBundle\Form\Type\BlockChoiceType;

class NodeController extends Controller
{
    
    /**
     * Cache containing blocks potentially used in current node.
     * This cache contains all blocks defined in nodes that are mentionned
     * in block references of the current node.
     * This is to prevent multiple loading of the same node document
     * when same external node is linked several times in the current node
     * 
     * @var Array
     */
    private $externalBlocks = array();
    
    
    /**
     * Contains blocks used in the current node,
     * either defined in current or external node
     * 
     * @var Array
     */
    private $blocks = array();
    
    
    /**
     * Render Node
     * 
     * @param int $nodeId
     * @return Response
     */
    public function showAction($nodeId)
    {
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        if (is_null($node)) {
            throw new NonExistingDocumentException("Node not found");
        }
        $areas = $node->getAreas();
        $this->externalBlocks = array();
        
        if (is_array($areas)) {
            foreach ($areas as $area) {
                $this->getBlocks(new Area($area), $nodeId);
            }
        }
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Node:show.html.twig',
            array('node' => $node, 'blocks' => $this->blocks, 'datetime' => time())
        );
        
        $response->setPublic();
        $response->setSharedMaxAge(15);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        
        return $response;
    }
    
    
    /** 
     * Get blocks referenced in an area and its subareas
     * 
     * @param Area $area
     * @param string $currentNodeId
     */
    protected function getBlocks(Area $area, $currentNodeId)
    {
        foreach ($area->getBlockReferences() as $blockReference) {
            $this->getBlockWithReference($blockReference, $currentNodeId);
        }
        
        foreach ($area->getSubAreas() as $subArea) {
            $this->getBlocks($subArea, $currentNodeId);
        }
    }
    
    
    /**
     * Get block with matching nodeId/blockId
     * and set it in the controller
     * 
     * @param Array $blockReference
     * @param string $currentNodeId
     */
    protected function getBlockWithReference($blockReference, $currentNodeId)
    {
        $realNodeId = $blockReference['nodeId'];
        if ($realNodeId == 0) {
            $realNodeId = $currentNodeId;
        }
            
        if (!(isset($this->externalBlocks[$realNodeId]))) {
            $this->getBlocksFromNode($realNodeId);
        }
        
        if (isset($this->externalBlocks[$realNodeId][$blockReference['blockId']])) {
            $this->blocks[$blockReference['nodeId']][$blockReference['blockId']] =
                $this->externalBlocks[$realNodeId][$blockReference['blockId']];
            $this->blocks[$blockReference['nodeId']][$blockReference['blockId']]['attributes']['_page_parameters'] =
                $this->container->get('request')->attributes->get('module_parameters');
        }
    }
    
    
    /**
     * Get blocks from specific Node, and cache them temporary for further request
     * 
     * @param int $nodeId
     */
    protected function getBlocksFromNode($nodeId)
    {
        $this->externalBlocks[$nodeId] = array();
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        
        if ($node) {
            $blocks = $node->getBlocks();
            if (!is_null($blocks)) {
                foreach ($blocks as $key => $block) {
                    $this->externalBlocks[$nodeId][$key]['component'] = $block->getComponent();
                    $this->externalBlocks[$nodeId][$key]['attributes'] = $block->getAttributes();
                }
            }
        }
    }
    
    
     /**
     * Test purpose : render a basic Node form
     * 
     * @param Request $request
     * @return Response
     */
    public function formAction($nodeId, Request $request)
    {
        $mandango = $this->container->get('mandango');
        
        if (empty($nodeId)){
            $node = $mandango->create('Model\PHPOrchestraCMSBundle\Node');
            $node->setSiteId(1);
            $node->setLanguage('fr');
        } else {
            $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
            $node->setVersion($node->getVersion() + 1);
        }

        $form = $this->createForm('node', $node);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $node->setId(null);
            $node->setIsNew(true);
            
            $node->save();
            return $this->redirect($this->generateUrl('php_orchestra_cms_node', array('nodeId' => $node->getNodeId())));
        }

        return $this->render(
            'PHPOrchestraCMSBundle:Node:form.html.twig',
            array(
                'form' => $form->createView(),
                'ajax' => $request->isXmlHttpRequest()
            )
        );
    }

    /**
     * List blocks from node filtered by those contained in config.yml
     * 
     */
    public function showBlocksFromNodeAction(Request $request)
    {
        $form = $this->get('form.factory')
            ->createNamedBuilder($request->get('form'), 'form')
            ->add(
                'blockId',
                new BlockChoiceType(
                    $this->container->get('mandango'),
                    $request->get('nodeId'),
                    $this->container->getParameter('php_orchestra.blocks')
                )
            )
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
}
