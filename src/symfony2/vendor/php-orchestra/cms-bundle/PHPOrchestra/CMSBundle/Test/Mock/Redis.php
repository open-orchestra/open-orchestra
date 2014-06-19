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

namespace PHPOrchestra\CMSBundle\Test\Mock;

/**
 * Description of Redis
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class Redis
{
    public function get($key)
    {
        
    }
    
    public function set($key, $value)
    {
        
    }
    
    public function hGetall($key)
    {
        
    }
    
    public function hmSet($key, $value)
    {
        
    }
    
    public function keys($pattern)
    {
        return 'listOfKeys';
    }
    
    public function del($keys)
    {
        
    }
}
