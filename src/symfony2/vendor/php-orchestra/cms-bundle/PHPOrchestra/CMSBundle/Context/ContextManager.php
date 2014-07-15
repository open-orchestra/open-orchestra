<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Context;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Centralize app contextual datas
 * 
 * @author Noël
 */
class ContextManager
{
    private $session = null;
    const KEY_LOCALE = '_locale';
    
    public function __construct($session, $defaultLocale = 'en')
    {
        $this->session = $session;
        if ($this->getCurrentLocale() == '') {
            $this->setCurrentLocale($defaultLocale);
        }
    }
    
    /**
     * Get current locale value
     */
    public function getCurrentLocale()
    {
        return $this->session->get(self::KEY_LOCALE);
    }

    /**
     * Set current locale
     * 
     * @param string $locale
     */
    public function setCurrentLocale($locale)
    {
        $this->session->set(self::KEY_LOCALE, $locale);
    }
}
