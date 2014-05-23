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
 * Description of BaseContentType
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
abstract class BaseContentType
{
    /**
     * @var string $id
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var int $contentTypeId
     * @MongoDB\Field(type="int")
     */
    protected $contentTypeId;
    
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
     * @var string $status
     * @MongoDB\Field(type="string")
     */
    protected $status;
    
    /**
     * @var boolean $deleted
     * @MongoDB\Field(type="boolean")
     */
    protected $deleted;
    
    /**
     * @var array $fields
     * @MongoDB\Field(type="hash")
     */
    protected $fields;
}
