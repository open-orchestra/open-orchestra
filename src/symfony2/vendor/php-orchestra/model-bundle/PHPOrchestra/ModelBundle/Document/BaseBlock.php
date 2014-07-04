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

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Description of BaseBlock
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 * 
 * @MongoDB\EmbeddedDocument
 */
abstract class BaseBlock
{
    /**
     * @var string $component
     * @MongoDB\Field(type="string")
     */
    protected $component;
    
    /**
     * @var hash $attributes
     * @MongoDB\Field(type="hash")
     */
    protected $attributes;


    /**
     * Set component
     *
     * @param string $component
     * @return self
     */
    public function setComponent($component)
    {
        $this->component = $component;
        return $this;
    }

    /**
     * Get component
     *
     * @return string $component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set attributes
     *
     * @param hash $attributes
     * @return self
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get attributes
     *
     * @return hash $attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
