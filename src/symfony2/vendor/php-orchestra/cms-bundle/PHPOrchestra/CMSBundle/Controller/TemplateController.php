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
use PHPOrchestra\CMSBundle\Document\DocumentLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use PHPOrchestra\CMSBundle\Helper\TemplateHelper;
use Mandango;

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
        $mandango = $this->container->get('mandango');
        if (empty($templateId)) {
            $template = $mandango->create('Model\PHPOrchestraCMSBundle\Template');
            $template->setSiteId(1);
            $template->setLanguage('fr');
        } else {
            $template = DocumentLoader::getDocument(
                'Template',
                array('templateId' => $templateId),
                $this->container->get('mandango')
            );
            $template->setVersion($template->getVersion() + 1);
        }
        
        $form = $this->createForm('template', $template, array(
            'action' => $this->getRequest()->getUri(),
           ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $template->setId(null);
            $template->setIsNew(true);
            
            $template->save();
            return $this->redirect(
                $this->generateUrl(
                    'php_orchestra_cms_templateform',
                    array('templateId' => $template->getTemplateId(), 'ajax' => $request->isXmlHttpRequest())
                )
            );
        }
        
        return $this->render(
            'PHPOrchestraCMSBundle:Template:form.html.twig',
            array(
                'form' => $form->createView(),
                'ajax' => $request->isXmlHttpRequest()
            )
        );
    }
    
    /**
     * send template cutting
     * 
     */
    public function showCuttingAction(Request $request)
    {
        $template = DocumentLoader::getDocument(
            'Template',
            array('templateId' => $request->get('templateId')),
            $this->container->get('mandango')
        );
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                array(
                    'success' => true,
                    'data' => TemplateHelper::formatTemplate($template, $this->container->get('mandango'))
                )
            );
        }
    }
}
