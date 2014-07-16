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
    
    private $documentsMapping = array(
        'Node' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\Node',
            'defaultSort' => array('version' => -1)
        ),
        'Template' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\Template',
            'defaultSort' => array('version' => -1)
        ),
        'Block' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\Block'
        ),
        'Site' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\Site'
        ),
        'ContentType' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\ContentType',
            'defaultSort' => array('contentTypeId' => -1, 'version' => -1)
        ),
        'Content' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\Content',
            'defaultSort' => array('contentId' => 1, 'version' => -1)
        ),
        'ContentAttribute' => array(
            'namespace' => 'Model\PHPOrchestraCMSBundle\ContentAttribute'
        )
    );
    
    
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
     * Get a single MongoDB document given by its type and search citerias
     * 
     * @param string $documentType
     * @param array $criteria
     */
    public function getDocument($documentType, array $criteria = array(), $asArray = false)
    {
        $sort = $this->getDefaultSort($documentType);
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        $query->sort($sort);
        $document = $query->one();
        if ($asArray) {
            $document = $document->toArray();
        }
        
        return $document;
    }
    
    /**
     * Get a single MongoDB document given by its _id
     * 
     * @param string $id
     */
    public function getDocumentById($documentType, $documentId, $asArray = false)
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $document = $repository->findOneById($documentId);
        if ($asArray) {
            $document = $document->toArray();
        }
        return $document;
    }
    
    /** 
    * Get all MongoDB documents matching type and search citerias
    * 
    * @param string $documentType
    * @param array $criteria
    * @param array $sort
    * @param bool $asArray, true to getdocuments as array, false to get as objects
    */
    public function getDocuments(
        $documentType,
        array $criteria = array(),
        $sort = array(),
        $asArray = false,
        $start = 0,
        $length = 0
    ) {
        if (array() == $sort) {
            $sort = $this->getDefaultSort($documentType);
        }
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        $query->sort($sort);
        if ($length == 0) {
            $documents = $query->all();
        } else {
            $documents = $query->skip($start)->limit($length);
        }
        if ($asArray) {
            $documents = $this->adaptToArray($documents);
        }
        return $documents;
    }
    
    /**
     * Get the number of documents matching $documentType and $criteria
     * 
     * @param dstring $documentType
     * @param array $criteria
     */
    public function getDocumentsCount($documentType, array $criteria = array())
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        return $query->count();
    }
    
    /**
     * Tranform a collection into an array
     *
     * @param $collection
     */
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
        if (!isset($this->documentsMapping[$documentType])) {
            throw new UnrecognizedDocumentTypeException('Unrecognized document type : ' . $documentType);
        }
        return $this->documentsMapping[$documentType]['namespace'];
    }
    
    
    /**
     * Get default sort filter for given document type
     * @param string $documentType
     */
    protected function getDefaultSort($documentType)
    {
        if (!isset($this->documentsMapping[$documentType])) {
            throw new UnrecognizedDocumentTypeException('Unrecognized document type : ' . $documentType);
        }
        
        $sort = array();
        
        if (isset($this->documentsMapping[$documentType]['defaultSort'])) {
            $sort = $this->documentsMapping[$documentType]['defaultSort'];
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
            '$group' =>
                array(
                    '_id' => '$nodeId',
                    'version' => array('$first' => '$version'),
                    'parentId' => array('$first' => '$parentId'),
                    'name' => array('$first' => '$name'),
                    'deleted' => array('$first' => '$deleted'),
                    'blocks' => array('$first' => '$blocks'),
                )
        );
        $versions = $repository->getCollection()->aggregate($filters);
        
        return $versions['result'];
    }
    
    /**
     * Return sons of $nodeId
     * 
     * @param string $nodeId
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
                '$group' =>
                    array(
                        '_id' => '$templateId',
                        'version' => array('$first' => '$version'),
                        'name' => array('$first' => '$name'),
                        'deleted' => array('$first' => '$deleted')
                    )
            )
        );
        
        return $versions['result'];
    }
    
    /**
     * Return an array containing informations about the last versions of all nodes
     */
    public function getContentTypesInLastVersion(array $additionnalFilters = array())
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace('ContentType'));
        
        $filters = array(
            array(
                '$match' =>
                    array(
                        'status' => 'published',
                        'deleted' => false
                    )
            ),
            array('$sort' => array('version' => -1))
        );
        
        foreach ($additionnalFilters as $filter) {
            $filters[] = $filter;
        }
        
        $filters[] = array(
            '$group' =>
                array(
                    '_id' => '$contentTypeId',
                    'version' => array('$first' => '$version'),
                    'name' => array('$first' => '$name'),
                    'status' => array('$first' => '$status'),
                    'deleted' => array('$first' => '$deleted')
                )
        );
        
        $versions = $repository->getCollection()->aggregate($filters);
        return $versions['result'];
    }

    /**
     * Get a list of distinct contents grouped by contentId
     * ie only 1 version of each content (for all combinations of version/language)
     * 
     * @param array $criteria
     * @param int $offset
     * @param int $length
     * @param array $sort
     */
    public function getGroupedContentsByContentId(array $criteria = array(), $offset = 0, $length = 0, $sort = array())
    {
        if (count($sort) == 0) {
            $sort = $this->getDefaultSort('Content');
        }
        
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace('Content'));
        
        $filters = array(
            array('$match' => $criteria),
            array('$sort' => $sort)
        );
        
        $filters[] = array(
            '$group' =>
                array(
                    '_id' => '$contentId',
                    'id' => array('$first' => '$_id'),
                    'version' => array('$first' => '$version'),
                    'language' => array('$first' => '$language'),
                    'shortName' => array('$first' => '$shortName'),
                    'status' => array('$first' => '$status'),
                    'contentType' => array('$first' => '$contentType'),
                    'contentId' => array('$first' => '$contentId')
                )
        );
        
        if ($offset !=0) {
            $filters[] = array('$skip' => $offset);
        }
        
        if ($length !=0) {
            $filters[] = array('$limit' => $length);
        }
        
        $contents = $repository->getCollection()->aggregate($filters);
        
        return $contents['result'];
    }
    
    /**
     * Get a list of distinct content types grouped by contentTypeId
     * ie only the last version of each content type
     * 
     * @param array $criteria
     * @param int $offset
     * @param int $length
     * @param array $sort
     */
    public function getContentTypesGroupedByContentTypeId(
        array $criteria = array(),
        $offset = 0,
        $length = 0,
        $sort = array()
    ) {
        if (count($sort) == 0) {
            $sort = $this->getDefaultSort('ContentType');
        }
        
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace('ContentType'));
        
        $filters = array(array('$sort' => $sort));
        
        if (count($criteria) > 0) {
            $filters[] = array('$match' => $criteria);
        }
        
        $filters[] = array(
            '$group' =>
                array(
                    '_id' => '$contentTypeId',
                    'id' => array('$first' => '$_id'),
                    'version' => array('$first' => '$version'),
                    'name' => array('$first' => '$name'),
                    'status' => array('$first' => '$status'),
                    'contentTypeId' => array('$first' => '$contentTypeId'),
                )
        );
        
        if ($offset !=0) {
            $filters[] = array('$skip' => $offset);
        }
        
        if ($length !=0) {
            $filters[] = array('$limit' => $length);
        }
        
        $contents = $repository->getCollection()->aggregate($filters);
        
        return $contents['result'];
    }
    
    /**
     * Return a block in a node
     */
    public function getBlockInNode($nodeId, $blockId)
    {
        $filters = array(
            array(
                '$match' =>
                    array(
                        'nodeId' => $nodeId
                    )
            )
        );
        $node = $this->getNodesInLastVersion($filters);
        if (count($node) > 0) {
            $node = $node[0];
            if (array_key_exists('blocks', $node) && array_key_exists($blockId, $node['blocks'])) {
                return $node['blocks'][$blockId];
            }
        }
        
        return null;
    }
}
