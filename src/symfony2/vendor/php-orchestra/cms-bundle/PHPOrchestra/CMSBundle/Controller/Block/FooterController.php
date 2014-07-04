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
    public function showAction($id, $class)
    {
        $mandango = $this->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $tree = $repository->getFooterTree();
        $tree = $repository->getTreeUrl($tree, $this->container);

        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/Footer:show.html.twig',
            array(
                'tree' => $tree,
                'id' => $id,
                'class' => $class,
            )
        );
        
        return $response;
    }


    /**
     * @see \PHPOrchestra\CMSBundle\Controller\Block\BlockInterface::showBackAction()
     */
    public function showBackAction($id, $class)
    {
        $mandango = $this->get('mandango');
        $repository = $mandango->getRepository('Model\PHPOrchestraCMSBundle\Node');
        $tree = $repository->getFooterTree();
        
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Footer:showBack.html.twig',
            array(
                'tree' => $tree,
                'id' => $id,
                'class' => $class,
            )
        );
    }
}
