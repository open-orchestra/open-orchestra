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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Search Controller
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 */
class SearchController extends Controller
{


    /**
     * Display search field
     */
    public function showAction($value, $name, $class, $nodeId)
    {
        // Search form
        $defaultData = null;
        $form = $this->createFormBuilder($defaultData)
            ->setAction($this->generateUrl('php_orchestra_cms_node', array('nodeId' => $nodeId)))
            ->add(
                'Search',
                'text'
            )->getForm();
        
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Search:show.html.twig',
            array(
                'form' => $form->createView(),
                'value' => $value,
                'name' => $name,
                'class' => $class,
                'nodeId' => $nodeId,
                'url' => 'php_orchestra_autocomplete',
            )
        );
    }


    /** 
     * @see \PHPOrchestra\CMSBundle\Controller\Block\BlockInterface::showBackAction()
     */
    public function showBackAction($value, $name, $class, $nodeId)
    {
        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('php_orchestra_cms_node', array('nodeId' => $nodeId)))
            ->add(
                'Search',
                'text'
            )->getForm();
        
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Search:showBack.html.twig',
            array(
                'form'   => $form->createView(),
                'value'  => $value,
                'name'   => $name,
                'class'  => $class,
                'nodeId' => $nodeId,
                'url'    => 'php_orchestra_autocomplete',
                )
        );
    }
}
