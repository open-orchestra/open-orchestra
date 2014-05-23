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
 * Description of BaseContent
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
abstract class BaseContent
{
    /**
     * @var string $id
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var int $contentId
     * @MongoDB\Field(type="int")
     */
    protected $contentId;
    
    /**
     * @var string $contentType
     * @MongoDB\Field(type="string")
     */
    protected $contentType;
    
    /**
     * @var int $siteId
     * @MongoDB\Field(type="int")
     */
    protected $siteId;
    
    /**
     * @var string $name
     * @MongoDB\Field(type="string")
     */
    protected $name;
    
    /**
     * @var int $version
     * @MongoDB\Field(type="int")
     */
    protected $version;
    
    /**
     * @var int $contentTypeVersion
     * @MongoDB\Field(type="int")
     */
    protected $contentTypeVersion;
    
    /**
     * @var string $language
     * @MongoDB\Field(type="string")
     */
    protected $language;
    
    /**
     * @var string $status
     * @MongoDB\Field(type="string")
     */
    protected $status;
    
    /**
     * @var boolean
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted;
    
    /**
     * @var array
     * @MongoDB\Field(type="hash")
     */
    protected $attributes = array();
}
