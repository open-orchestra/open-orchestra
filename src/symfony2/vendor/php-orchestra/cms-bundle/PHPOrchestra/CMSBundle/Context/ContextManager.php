<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Context;

use Symfony\Component\HttpFoundation\Session\Session;

class ContextManager
{
    private $session = null;
    
    public function __construct($session)
    {
        $this->session = $session;
        
        if ($this->session->get('bo_language') == '') {
            $this->session->set('bo_language', 'en');
        }
    }
    
    /**
     * Get current locale value
     */
    public function getCurrentLocale()
    {
        return $this->session->get('bo_language');
    }

    /**
     * Set current locale
     * 
     * @param string $locale
     */
    public function setCurrentLocale($locale)
    {
        $this->session->set('bo_language', $locale);
    }
}
