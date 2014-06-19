<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas Anne <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Form\Type\TemplateType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use PHPOrchestra\CMSBundle\Helper\TemplateHelper;

class TemplateController extends Controller
{
    
    /**
     * 
     * Render the templates form
     * @param int $templateId
     * @param Request $request
     * 
     */
    public function formAction($templateId, Request $request)
    {
        $documentManager = $this->container->get('phporchestra_cms.documentmanager');
        
        if (empty($templateId)) {
            $template = $documentManager->createDocument('Template');
            $template->setSiteId(1);
            $template->setLanguage('fr');
        } else {
            $template = $documentManager->getDocument(
                'Template',
                array('templateId' => $templateId)
            );
            $template->setVersion($template->getVersion() + 1);
        }
        
        $form = $this->createForm(
            'template',
            $template,
            array(
                'inDialog' => true,
                'js' => 'pagegenerator/template.js',
                'action' => $this->getRequest()->getUri()
            )
        );
        if ($request->getMethod() == 'POST') {
	        $form->handleRequest($request);
	        if ($form->isValid()) {
	            $template->setId(null);
	            $template->setIsNew(true);
	            $template->save();
	            
	            return $this->render(
	                'PHPOrchestraCMSBundle:BackOffice/Editorial:simpleMessage.html.twig',
	                array('message' => 'Edition ok')
	            );
	        }
        }
        
        return $this->render(
            'PHPOrchestraCMSBundle:Form:template.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }
    
    /**
     * send template cutting
     * 
     */
    public function showCuttingAction(Request $request)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        $template = $documentManager->getDocument(
            'Template',
            array('templateId' => $request->get('templateId'))
        );
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => TemplateHelper::formatTemplate($template, $documentManager)
                )
            );
        }
    }
    
    /**
     * Delete all version of a template
     * 
     * @param Request $request
     */
    public function deleteAction($templateId)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        $templateVersions = $documentManager->getDocuments('Template', array('templateId' => $templateId));
        
        foreach ($templateVersions as $templateVersion) {
            $templateVersion->markAsDeleted();
        }
        
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice/Editorial:simpleMessage.html.twig',
            array('message' => 'Delete template process on ' . $templateId)
        );
        
    }
}
