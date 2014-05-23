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
 * Description of BaseUser
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
abstract class BaseUser
{
    /**
     * @var string $id
     * @MongoDB\Id
     */
    protected $id;
    
    /**
     * @var string $login
     * @MongoDB\Field(type="string")
     */
    protected $login;
    
    /**
     * @var string $hash
     * @MongoDB\Field(type="string")
     */
    protected $hash;
    
    /**
     * @var string $salt
     * @MongoDB\Field(type="string")
     */
    protected $salt;
    
    /**
     * @var string $firstName
     * @MongoDB\Field(type="string")
     */
    protected $firstName;
    
    /**
     * @var string $lastName
     * @MongoDB\Field(type="string")
     */
    protected $lastName;
    
    /**
     * @var string $email
     * @MongoDB\Field(type="string")
     */
    protected $email;
    
    /**
     * @var string $addresses
     * @MongoDB\Field(type="string")
     */
    protected $addresses;
}
