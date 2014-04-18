<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Cache;

use PHPOrchestra\CMSBundle\Cache\CacheManagerInterface;

class RedisCacheManager implements CacheManagerInterface
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
     * Get value from cache
     * 
     * @param string $key
     */
    public function get($key)
    {
        $value = $this->keystoreService->get($key);
        
        if (empty($value)) {
            $value = $this->keystoreService->hGetall($key);
        }
        
        return $value;
    }


    /**
     * Set value to cache
     * 
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        if (is_array($value)) {
            $set = $this->keystoreService->hmSet($key, $value);
        } else {
            $set = $this->keystoreService->set($key, $value);
        }
        
        return $set;
    }
}
