<?php
/**
 * This file is part of the PHPOrchestra\ThemeBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Twig;

class AddHtmlExtension extends \Twig_Extension{
    private $top = array();
    private $bottom = array();

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'put_top' => new \Twig_Function_Method($this, 'putTop', array('is_safe' => array('html'))),
            'put_bottom' => new \Twig_Function_Method($this, 'putBottom', array('is_safe' => array('html'))),
            'print_top' => new \Twig_Function_Method($this, 'printTop', array('is_safe' => array('html'))),
            'print_bottom' => new \Twig_Function_Method($this, 'printBottom', array('is_safe' => array('html'))),
        );
    }

    public function putTop($html) {
        $this->top[] = $html;
    }
    public function putBottom($html) {
        $this->bottom[] = $html;
    }
    
    public function printTop() {
        return implode(PHP_EOL, $this->top);
    }
    public function printBottom() {
        return implode(PHP_EOL, $this->bottom);
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'add_html';
    }
}
