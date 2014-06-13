<?php

/*
* Business & Decision - Commercial License
*
* Copyright 2014 Business & Decision.
*
* All rights reserved. You CANNOT use, copy, modify, merge, publish,
* distribute, sublicense, and/or sell this Software or any parts of this
* Software, without the written authorization of Business & Decision.
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* See LICENSE.txt file for the full LICENSE text.
*/

namespace PHPOrchestra\BlockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Footer Controller
 *
 * @author benjamin fouche <benjamin.fouche@businessdecision.com>
 *
 */
class FooterController extends Controller
{


    /**
     * Display Footer
     * 
     * @param string $id    id of the footer
     * @param string $class class of the tags
     */
    public function showAction($_id, $_class)
    {
        $mandango = $this->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $tree = $repository->getFooterTree();

        $response = $this->render(
            'PHPOrchestraBlockBundle:Footer:show.html.twig',
            array(
                'tree' => $tree,
                'id' => $_id,
                'class' => $_class,
            )
        );
        
        /*$response->setPublic();
        $response->setSharedMaxAge(0);*/
        return $response;
    }


    /**
     * Render the dialog form
     * 
     * @param string $prefix
     */
    public function formAction($prefix)
    {
        $form = $this->get('form.factory')
        ->createNamedBuilder($prefix, 'form', null)
        ->add(
            'idFooter',
            'text'
        )
        ->add(
            'class',
            'text'
        )
        ->getForm();
        
        return $this->render(
            'PHPOrchestraBlockBundle:Footer:form.html.twig',
            array('form' => $form->createView())
        );
    }
}
