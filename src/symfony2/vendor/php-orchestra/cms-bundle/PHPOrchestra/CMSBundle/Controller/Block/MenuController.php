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

namespace PHPOrchestra\CMSBundle\Controller\Block;

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
     * render Menu
     *
     * @param string $class class of the tag
     * @param string $id    id of the menu
     */
    public function showAction($class, $id)
    {
        $mandango = $this->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $tree = $repository->getMenuTree();

        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/Menu:show.html.twig',
            array(
                    'tree'  => $tree,
                    'class' => $class,
                    'id'    => $id
                )
        );
        
        return $response;
    }


    /**
     * @see \PHPOrchestra\CMSBundle\Controller\Block\BlockInterface::showBackAction()
     */
    public function showBackAction($class, $id)
    {
        $mandango = $this->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $tree = $repository->getMenuTree();
        
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Menu:showBack.html.twig',
            array(
                'tree'  => $tree,
                'class' => $class,
                'id'    => $id
            )
        );
    }
}
