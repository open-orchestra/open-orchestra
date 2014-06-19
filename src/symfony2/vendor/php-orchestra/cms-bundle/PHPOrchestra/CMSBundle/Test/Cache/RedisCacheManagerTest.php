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

namespace PHPOrchestra\CMSBundle\Test\cache;

use \PHPOrchestra\CMSBundle\Cache\RedisCacheManager;

/**
 * Unit tests of RedisCacheManager
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class RedisCacheManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->keystoreMock = $this->getMockBuilder('\\PHPOrchestra\\CMSBundle\\Test\\Mock\\Redis')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->redisCacheManager = new RedisCacheManager($this->keystoreMock);
    }
    
    /**
     * @dataProvider getData
     * 
     * @param string  $expectedValue
     * @param string  $key
     * @param string  $value
     * @param boolean $isHash
     */
    public function testGet($expectedValue, $key, $value, $isHash)
    {
        if ($isHash) {
            $this->keystoreMock
                ->expects($this->once())
                ->method('get')
                ->with($this->equalTo($key))
                ->will($this->returnValue(null));
        
            $this->keystoreMock
                ->expects($this->once())
                ->method('hGetAll')
                ->with($this->equalTo($key))
                ->will($this->returnValue($value));
        } else {
            $this->keystoreMock
                ->expects($this->once())
                ->method('get')
                ->with($this->equalTo($key))
                ->will($this->returnValue($value));
        }
        
        $result = $this->redisCacheManager->get($key);
        
        $this->assertEquals($expectedValue, $result);
    }
    
    /**
     * @dataProvider setData
     * 
     * @param string  $key
     * @param string  $value
     * @param boolean $isHash
     */
    public function testSet($key, $value, $isHash)
    {
        if ($isHash) {
            $this->keystoreMock
                ->expects($this->once())
                ->method('hmSet')
                ->with($this->equalTo($key), $this->equalTo($value));
        } else {
            $this->keystoreMock
                ->expects($this->once())
                ->method('set')
                ->with($this->equalTo($key), $this->equalTo($value));
        }
        
        $this->redisCacheManager->set($key, $value);
    }
    
    public function testDeleteKeys()
    {
        $this->keystoreMock
            ->expects($this->once())
            ->method('keys');
        
        $this->keystoreMock
            ->expects($this->once())
            ->method('del');
        
        $this->redisCacheManager->deleteKeys('somePatternToDelete');
    }
    
    public function getData()
    {
        return array(
            array('value1', 'key1', 'value1', false),
            array('value2', 'key2', 'value2', true),
            array('value3', 'key3', 'value3', false),
            array('value4', 'key4', 'value4', true),
        );
    }
    
    public function setData()
    {
        return array(
            array('key1', 'value1',                  false),
            array('key2', array('value2', 'value2'), true),
        );
    }
}
