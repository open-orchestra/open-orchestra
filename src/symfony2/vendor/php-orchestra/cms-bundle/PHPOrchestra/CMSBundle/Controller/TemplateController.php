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
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;

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
        if($templateId != 0){
            $template = DocumentLoader::getDocument('Template', array('templateId' => $templateId), $this->container->get('mandango'));
            $template->setVersion($template->getVersion() + 1);
        }
        else{
            $template = $mandango->create('Model\PHPOrchestraCMSBundle\Template');
            $template->setSiteId(1);
            $template->setLanguage('fr');
        }
        
        $form = $this->createForm(new TemplateType(), $template);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $template->setId(null);
            $template->setIsNew(true);
            
            $template->save();
            return $this->redirect($this->generateUrl('php_orchestra_cms_templateform', array('templateId' => $template->getTemplateId())));
        }
        
        return $this->render('PHPOrchestraCMSBundle:Template:form.html.twig', array(
            'form' => $form->createView(),
        ));    
    }       
}