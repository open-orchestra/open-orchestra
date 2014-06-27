<?php

namespace PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of TestContentType
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */
class TestContentType
{
    public function __construct($fields = array(), /*$customFieldsIndex = array(),*/ $new_field = '')
    {
        $this->setFields(json_encode($fields));
        $this->new_field = $new_field;
    }
    
    public function getFields()
    {
        return $this->fields;
    }
    
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
}
