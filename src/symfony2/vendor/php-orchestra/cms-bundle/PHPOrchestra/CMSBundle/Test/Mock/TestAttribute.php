<?php

namespace PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of TestAttribute
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class TestAttribute
{
    public function __construct($name = '', $value = '')
    {
        $this->setName($name);
        $this->setValue($value);
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
}
