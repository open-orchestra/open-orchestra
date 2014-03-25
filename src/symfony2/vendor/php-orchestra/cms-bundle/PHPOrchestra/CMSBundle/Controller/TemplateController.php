<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas Anne <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Classes\Area;
use PHPOrchestra\CMSBundle\Form\Type\TemplateType;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;

class TemplateController extends Controller
{

    
    /**
     * Cache containing blocks defined in external Nodes
     * 
     * @var Mandango\Group\EmbeddedGroup[]
     */
    private $externalBlocks = array();
    

    /**
     * Render Template
     * 
     * @param int $templateId
     * @return Response
     */
    public function showAction($templateId)
    { 
        $template = DocumentLoader::getDocument('Template', array('templateId' => (int)$templateId), $this->container->get('mandango'));
        $areas = $template->getAreas();
        $this->externalBlocks = array();
        
        if (is_array($areas))
            foreach ($areas as $area)
                $this->getExternalBlocks(new Area($area));

        return $this->render('PHPOrchestraCMSBundle:Template:show.html.twig', array('template' => $template, 'relatedNodes' => $this->externalBlocks));
    }
    
    
    /** 
     * Cache blocks from external Nodes referenced in an area
     * 
     * @param Area $area
     */
    private function getExternalBlocks(Area $area)
    {
        foreach ($area->getBlockReferences() as $blockReference)
           if ($blockReference['nodeId'] != 0 && !(isset($this->cacheRelatedNodes[$blockReference['nodeId']])))
               $this->getBlocksFromNode($blockReference['nodeId']);
            
        foreach ($area->getSubAreas() as $subArea)
            $this->getExternalBlocks($subArea);
    }
    
    
    /**
     * Cache blocks from specific Node
     * 
     * @param int $templateId
     */
    private function getBlocksFromNode($nodeId)
    {
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $this->container->get('mandango'));
        $this->externalBlocks[$nodeId] = $nodes->getBlocks();
    }
	
    /**
     * 
     * Render the templates form
     * @param int $templateId
     * @param Request $request
     * 
     */
    public function formAction($templateId, Request $request)
    {
        $mandango = $this->container->get('mandango');       
        if($templateId != 0){
            $template = DocumentLoader::getDocument('Template', array('templateId' => (int)$templateId), $this->container->get('mandango'));
            $template->setVersion($template->getVersion() + 1);
        }
        else{
            $template = $mandango->create('Model\PHPOrchestraCMSBundle\Template');
            $template->setSiteId(1);
            $template->setLanguage('fr');
        }
        
        $form = $this->createForm(new TemplateType(), $template, array('showDialog' => true));
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $template->save();
            return $this->redirect($this->generateUrl('php_orchestra_cms_templateform', array('templateId' => $template->getTemplateId())));
        }
        else{
        	var_dump($form->getErrors());
        	//var_dump($request);
        	//var_dump('failed');
        }
        
        return $this->render('PHPOrchestraCMSBundle:Template:form.html.twig', array(
            'form' => $form->createView(),
        ));    
    }       
}