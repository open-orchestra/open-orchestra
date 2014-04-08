<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Classes;

class CacheManager
{
    /**
     * keystore service
     * @var unknown_type
     */
    protected $keystoreService = null;
    
    
    /**
     * Constucteur
     * 
     * @param unknown_type $keystoreService
     */
    public function __construct($keystoreService)
    {
        $this->keystoreService = $keystoreService;
    }
    
    
    /**
     * get scalar value from cache
     * 
     * @param string $key
     */
    public function get($key)
    {
        return $this->keystoreService->get($key);
    }
    
    
    /**
     * get hash value from cache
     * 
     * @param string $key
     */
    public function hashGet($key)
    {
        return $this->keystoreService->hGetall($key);
    }
    
    
    /**
     * Set scalar value to cache
     * 
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        return $this->keystoreService->set($key, $value);
    }
    
    
    /**
     * Set hash value to cache
     * 
     * @param string $key
     * @param string[] $hash
     */
    public function hashSet($key, $hash)
    {
        return $this->keystoreService->hmSet($key, $hash);
    }

}