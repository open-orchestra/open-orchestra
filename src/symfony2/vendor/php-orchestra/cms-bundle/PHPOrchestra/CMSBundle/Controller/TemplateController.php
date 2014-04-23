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
        $documentLoader = $this->container->get('phporchestra_cms.documentloader');
        
        $ajax = false;
        
        if (empty($templateId)) {
            $template = $documentLoader->createDocument('Template');
            $template->setSiteId(1);
            $template->setLanguage('fr');
        } else {
            $template = $documentLoader->getDocument(
                'Template',
                array('templateId' => $templateId)
            );
            $template->setVersion($template->getVersion() + 1);
            $ajax = true;
        }
        
        $form = $this->createForm(
            'template',
            $template,
            array(
                'action' => $this->getRequest()->getUri()
            )
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $template->setId(null);
            $template->setIsNew(true);
            
            $template->save();
            return $this->redirect($this->generateUrl('php_orchestra_cms_bo'));
        }
        
        return $this->render(
            'PHPOrchestraCMSBundle:Form:template.html.twig',
            array(
                'form' => $form->createView(),
                'ajax' => $ajax
            )
        );
    }
    
    /**
     * send template cutting
     * 
     */
    public function showCuttingAction(Request $request)
    {
        $documentLoader = $this->get('phporchestra_cms.documentloader');
        $template = $documentLoader->getDocument(
            'Template',
            array('templateId' => $request->get('templateId'))
        );
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => TemplateHelper::formatTemplate($template, $documentLoader)
                )
            );
        }
    }
    
    /**
     * Delete all version of a template
     * 
     * @param Request $request
     */
    public function deleteAction(Request $request)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:BackOffice:simpleMessage.html.twig',
            array(
                'message' => 'Delete template process on ' . $request->get('nodeId')
            )
        );
    }
    
}
