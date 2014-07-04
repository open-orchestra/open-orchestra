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
 * Description of TinyMCEWysiwygController
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class TinyMCEWysiwygController extends Controller
{
    
    /**
     * Display HTML
     * 
     * @param string $htmlContent HTML to render
     */
    public function showAction($_htmlContent = array(), $_page_parameters = array())
    {
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/TinyMCEWysiwyg:show.html.twig',
            array(
                  'htmlContent' => $_htmlContent
            )
        );
        
        $response->setPublic();
        $response->setSharedMaxAge(0);
        return $response;
    }

    /**
     * Display HTML fort BO
     * 
     * @param string $htmlContent HTML to render
     */
    public function showBackAction($_htmlContent = array())
    {
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/TinyMCEWysiwyg:show.html.twig',
            array(
                  'htmlContent' => $_htmlContent
            )
        );
        
        return $response;
    }
}
