<?php
/**
 * This file is part of the PHPOrchestra\ThemeBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Twig;

class AddHtmlExtension extends \Twig_Extension
{
    private $top_html = array();
    private $bottom_html = array();
    private $js = array();
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'unshift_html' => new \Twig_Function_Method($this, 'unshiftHtml', array('is_safe' => array('html'))),
            'push_html' => new \Twig_Function_Method($this, 'pushHtml', array('is_safe' => array('html'))),
            'print_html' => new \Twig_Function_Method($this, 'printHtml', array('is_safe' => array('html'))),
            'unshift_js' => new \Twig_Function_Method($this, 'unshiftJs', array('is_safe' => array('html'))),
            'push_js' => new \Twig_Function_Method($this, 'pushJs', array('is_safe' => array('html'))),
            'print_js' => new \Twig_Function_Method($this, 'printJs', array('is_safe' => array('html'))),
        );
    }

    public function unshiftHtml($value)
    {
        $html = $this->top_html;
        array_unshift($html, $value);
        $this->top_html = $html;
    }

    public function pushHtml($value)
    {
        $html = $this->bottom_html;
        array_push($html, $value);
        $this->bottom_html = $html;
    }
    
    public function printHtml($value)
    {
        return implode(PHP_EOL, $this->top_html).$value.implode(PHP_EOL, $this->bottom_html);
    }
    
    public function unshiftJs($value)
    {
        $js = $this->js;
        array_unshift($js, $value);
        $this->js = $js;
    }

    public function pushJs($value)
    {
        $js = $this->js;
        array_push($js, $value);
        $this->js = $js;
    }
        
    public function printJs($debug = false)
    {
        $html = '';
        if (count($this->js) > 0) {
            $html .= '<script>';
            foreach ($this->js as $key => $script) {
                $html .= 'function dt_'.$key.'(){';
                if ($debug) {
                    $html .= 'console.log("'.$script.'");';
                }
                $html .= 'loadScript("'.$script.'", dt_'.($key + 1).');';
                $html .= '}';
            }
            $html .= 'function dt_'.($key + 1).'(){}';
            $html .= 'dt_0();';
            $html .= '</script>';
        }
        return $html;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'add_html';
    }
}
