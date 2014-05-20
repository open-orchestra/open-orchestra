<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Document;

use PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException;

/**
 * Manage documents
 * 
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */
class DocumentManager
{
    private $documentsService = null;
    
    /**
     * DocumentManager service constructor
     * 
     * @param unknown_type $documentsService The documents storage service
     */
    public function __construct($documentsService)
    {
        $this->documentsService = $documentsService;
    }
    
    /**
     * Factory method
     * 
     * @param string $documentType
     */
    public function createDocument($documentType)
    {
        return $this->documentsService->create($this->getDocumentNamespace($documentType));
    }
    
    /** 
    * Get a single MongoDB document giving its type and search citerias
    * 
    * @param string $documentType
    * @param array $criteria
    */
    public function getDocument($documentType, array $criteria = array())
    {
        $sort = $this->getDefaultSort($documentType);
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        $query->sort($sort);
        return $query->one();
    }
    
    /** 
    * Get all MongoDB documents matching type and search citerias
    * 
    * @param string $documentType
    * @param array $criteria
    * @param array $sort
    * @param bool $asArray, true to getdocuments as array, false to get as objects
    */
    public function getDocuments($documentType, array $criteria = array(), $sort = array(), $asArray = false)
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        $query->sort($sort);
        $documents = $query->all();
         if ($asArray) {
            $documents = $this->adaptToArray($documents);
        }
        return $documents;
    }
    
    public function adaptToArray($collection)
    {
        $documents = array();
        foreach ($collection as $document) {
            $documents[] = $document->toArray();
        }
        return $documents;
    }
    
    /**
     * Get documentType model namespace
     * 
     * @param string $documentType
     */
    protected function getDocumentNamespace($documentType)
    {
        $documentNamespaces = array(
            'Node' => 'Model\PHPOrchestraCMSBundle\Node',
            'Template' => 'Model\PHPOrchestraCMSBundle\Template',
            'Block' => 'Model\PHPOrchestraCMSBundle\Block',
            'Site' => 'Model\PHPOrchestraCMSBundle\Site',
            'ContentType' => 'Model\PHPOrchestraCMSBundle\ContentType',
            'Content' => 'Model\PHPOrchestraCMSBundle\Content'
        );
        if (isset($documentNamespaces[$documentType])) {
            return $documentNamespaces[$documentType];
        } else {
            throw new UnrecognizedDocumentTypeException('Unrecognized document type : ' . $documentType);
        }
    }
    
    
    /**
     * Get default sort filter for given document type
     * @param string $documentType
     */
    protected function getDefaultSort($documentType)
    {
        $sort = array();
        switch($documentType)
        {
            case 'Node':
            case 'Template':
                $sort = array('version' => -1);
                break;
            default:
                throw new UnrecognizedDocumentTypeException('Unrecognized document type : ' . $documentType);
        }
        return $sort;
    }
    
    /**
     * Return an array containing informations about the last versions of all nodes
     */
    public function getNodesInLastVersion(array $additionnalFilters = array())
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace('Node'));
        
        $filters = array(array('$sort' => array('version' => -1)));
        
        foreach ($additionnalFilters as $filter) {
            $filters[] = $filter;
        }
        
        $filters[] = array(
                            '$group' => array(
                                '_id' => '$nodeId',
                                'version' => array('$first' => '$version'),
                                'parentId' => array('$first' => '$parentId'),
                                'name' => array('$first' => '$name'),
                                'deleted' => array('$first' => '$deleted')
                            )
        );
        
        $versions = $repository->getCollection()->aggregate($filters);
        
        return $versions['result'];
    }
    
    /**
     * 
     */
    public function getNodeSons($nodeId)
    {
        $filters = array(array('$match' => array('parentId' => $nodeId)));
        
        return $this->getNodesInLastVersion($filters);
    }
    
    /**
     * Return an array containing informations about the last versions of all templates
     */
    public function getTemplatesInLastVersion()
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace('Template'));
        
        $versions = $repository->getCollection()->aggregate(
            array(
                '$sort' => array('version' => -1),
            ),
            array(
                '$group' => array(
                    '_id' => '$templateId',
                    'version' => array('$first' => '$version'),
                    'name' => array('$first' => '$name'),
                    'deleted' => array('$first' => '$deleted')
                )
            )
        );
        
        return $versions['result'];
    }
}
