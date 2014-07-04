<?php
/**
 * This file is part of the PHPOrchestra\ThemeBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Twig;

class LexiconTranslatorExtension extends \Twig_Extension
{

    protected $lexic = array('symfonyTypeToSmartType' => array('choice' => 'select',
                                    'text' => 'input'));
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('lexicon_translator', array($this, 'lexiconTranslatorFilter')),
        );
    }

    public function lexiconTranslatorFilter($key, $fromto = "symfonyTypeToSmartType")
    {
        if (array_key_exists($fromto, $this->lexic) && array_key_exists($key, $this->lexic[$fromto])) {
            return $this->lexic[$fromto][$key];
        } else {
            return $key;
        }
    }

    public function getName()
    {
        return 'lexicon_translator';
    }
}
