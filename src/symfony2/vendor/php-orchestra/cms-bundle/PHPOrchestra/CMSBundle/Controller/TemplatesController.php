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
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use Symfony\Component\HttpFoundation\Request;
use PHPOrchestra\CMSBundle\Helper\NodesHelper;

class TemplatesController extends Controller
{

    /**
     * List all nodes
     * 
     */
    public function showAllTemplatesAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamedBuilder($request->get('form'), 'form')
            ->add('templateId', 'orchestra_template_choice')
            ->getForm();
        $render = $this->render('PHPOrchestraCMSBundle:Form:input.html.twig', array(
            'form' => $form->createView()
        ));
        if($request->isXmlHttpRequest()){
            return new JsonResponse(array(
                'success' => true,
                'data' => $render->getContent()
            ));
        }
        else{
            return new Response($render->getContent());
        }
    }
}
