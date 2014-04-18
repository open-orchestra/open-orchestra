<?php

namespace PHPOrchestra\CMSBundle\Test\Mock;

use Mandango\MetadataFactory;
use Mandango\Cache\CacheInterface;

/**
 * Description of Mandango
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class Mandango extends \Mandango\Mandango
{
    /**
     * Fake Data Set
     * array(
     *     'Collection1' => array(array(doc1), array(doc2),...),
     *     'Collection2' => array(array(doc1), array(doc2),...),
     * );
     * 
     * @var array
     */
    protected $database;

    /**
     * {@inheritdoc}
     * 
     * @param \Mandango\MetadataFactory $metadataFactory
     * @param \Mandango\Cache\CacheInterface $cache
     * @param type $loggerCallable
     */
    public function __construct(
        MetadataFactory $metadataFactory = null,
        CacheInterface $cache = null,
        $loggerCallable = null
    ) {
        $this->metadataFactory = $metadataFactory;
        $this->cache           = $cache;
        $this->loggerCallable  = $loggerCallable;
        $this->database        = array();
    }

    /**
     * Returns repositories by document class.
     *
     * @param string $documentClass The document class.
     *
     * @return MandangoDocumentRepository The repository.
     */
    public function getRepository($documentClass)
    {
        $repository = new MandangoDocumentRepository($this);
        $repository->setDocumentClass($documentClass);
        
        return $repository;
    }
    
    /**
     * Sets the data set
     * @example setDB(array(
     *     'Model\PHPOrchestraCMSBundle\Node' => array(
     *         array('_id' => 'abcd', 'field' => 'value', ...),
     *         array('_id' => 'abce', 'field' => 'value', ...),
     *         array('_id' => 'abcf', 'field' => 'value', ...),
     *     ),
     *     'Model\PHPOrchestraCMSBundle\Template' => array(
     *         array('_id' => 'abcd', 'field' => 'value', ...),
     *         array('_id' => 'abce', 'field' => 'value', ...),
     *         array('_id' => 'abcf', 'field' => 'value', ...),
     *     ),
     * );
     * 
     * @param array $dbContent Fake data set
     */
    public function setDB(Array $dbContent)
    {
        $this->database = $dbContent;
    }
    
    /**
     * Get the data set
     * 
     * @see $this->setDB()
     * @return array
     */
    public function getDB()
    {
        return $this->database;
    }
}
