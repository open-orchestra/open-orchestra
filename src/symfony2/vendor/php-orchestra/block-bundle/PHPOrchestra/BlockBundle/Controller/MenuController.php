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
use Symfony\Component\HttpFoundation\Response;

/**
 * Menu Controller
 * 
 * @author benjamin fouche <benjamin.fouche@businessdecision.com>
 *
 */
class MenuController extends Controller
{
    /**
     * display Menu
     *
     * @param string $class class of the tag
     * @param string $id    id of the menu
     */
    public function showAction($_class, $_id)
    {
        $mandango = $this->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $tree = $repository->getMenuTree();

        $response = $this->render(
            'PHPOrchestraBlockBundle:Menu:show.html.twig',
            array(
                    'tree'  => $tree,
                    'class' => $_class,
                    'id'    => $_id
                )
        );
        
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
                'class',
                'text'
            )
            ->add(
                'idMenu',
                'text'
            )
            ->getForm();
    
        return $this->render(
            'PHPOrchestraBlockBundle:Menu:form.html.twig',
            array('form' => $form->createView())
        );
    }
}
