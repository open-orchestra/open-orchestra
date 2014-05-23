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
 * Description of BaseSite
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
abstract class BaseSite
{
    /**
     * @var string $id
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var int $siteId
     * @MongoDB\Field(type="int")
     */
    protected $siteId;
    
    /**
     * @var string $domain
     * @MongoDB\Field(type="string")
     */
    protected $domain;
    
    /**
     * @var string $alias
     * @MongoDB\Field(type="string")
     */
    protected $alias;
    
    /**
     * @var string $defaultLanguage
     * @MongoDB\Field(type="string")
     */
    protected $defaultLanguage;
    
    /**
     * @var array $languages
     * @MongoDB\Field(type="collection")
     */
    protected $languages = array();
    
    /**
     * @var PHPOrchestraModel\MongoBundle\Document\Block
     * @MongoDB\EmbedMany(targetDocument="PHPOrchestraModel\MongoBundle\Document\Block")
     */
    protected $blocks = array();
}
