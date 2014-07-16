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

use PHPOrchestra\CMSBundle\Form\Type\AutocompleteSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Search Controller
 * 
 * @author Benjamin Fouché <benjamin.fouche@businessdecision.com>
 */
class SearchController extends Controller
{


    /**
     * Display search field
     *
     * @param string $value
     * @param string $class
     * @param string $nodeId
     * @param int    $limit
     */
    public function showAction($value, $class, $nodeId, $limit = 6)
    {
        // Search form
        $form = $this->generateSearchForm($value, $class, $nodeId, $limit);

        return $this->render(
            'PHPOrchestraCMSBundle:Block/Search:show.html.twig',
            array(
                'form' => $form->createView(),
                'url' => 'php_orchestra_autocomplete'
            )
        );
    }


    /** 
     * @see \PHPOrchestra\CMSBundle\Controller\Block\BlockInterface::showBackAction()
     */
    public function showBackAction($value, $class, $nodeId, $limit = 6)
    {
        $form = $this->generateSearchForm($value, $class, $nodeId, $limit);
        
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Search:showBack.html.twig',
            array(
                'form'   => $form->createView(),
                )
        );
    }

    /**
     * @param string $value
     * @param string $class
     * @param string $nodeId
     * @param int    $limit
     *
     * @return \Symfony\Component\Form\Form
     */
    protected function generateSearchForm($value, $class, $nodeId, $limit)
    {
        $form = $this->createForm(
            new AutocompleteSearchType(
                $this->generateUrl('php_orchestra_autocomplete', array('limit' => $limit)),
                $value,
                $class
            ),
            null,
            array(
                'action' => $this->generateUrl('php_orchestra_cms_node', array('nodeId' => $nodeId)),
                'method' => 'GET',
            )
        );

        return $form;
    }
}
