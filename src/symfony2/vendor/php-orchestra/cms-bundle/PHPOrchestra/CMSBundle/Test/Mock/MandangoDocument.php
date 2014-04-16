<?php

namespace PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of MandangoDocument
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class MandangoDocument extends \Mandango\Document\Document
{
    /**
     * Initializes a document with provided data
     * 
     * @param array $data Data to set
     */
    public function setDocumentData(array $data)
    {
        foreach ($data as $field => $value) {
            $setter = 'set' . $this->fieldNameToAttributeName($field);
            $this->$setter($value);
        }
    }
    
    /**
     * 'Magically' creates the getters and setters for every document attributes
     * getNodeId, setNodeId, etc.
     * 
     * @param string $name Method name
     * @param mixed $arguments Arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (0 === strpos($name, 'get')) {
            $field = substr($name, 3);
            return $this->data['fields'][$field];
        } elseif (0 === strpos($name, 'set')) {
            $field = substr($name, 3);
            $this->data['fields'][$field] = $arguments[0];
        }
    }
    
    /**
     * Transforms a field_name to an AttributeName
     * (snake_case to CamelCase)
     * 
     * @param string $fieldName snake_cased field Name
     * @return string
     */
    public function fieldNameToAttributeName($fieldName)
    {
        return ucfirst(
            preg_replace_callback(
                '/_([a-z])/',
                function ($matches) {
                    return strtoupper($matches[1]);
                },
                $fieldName
            )
        );
    }
}
