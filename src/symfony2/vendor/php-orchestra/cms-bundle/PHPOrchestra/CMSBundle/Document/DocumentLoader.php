<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Document;

use PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException;

/**
 * Get documents from storage
 * 
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */
class DocumentLoader
{
    private $documentsService = null;
    
    /**
     * DocumentLoader service constructor
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
    * Get a MongoDB document giving its type and search citerias
    * 
    * @param string $documentType
    * @param array $criteria
    * @param unknown $documentsService
    */
    public function getDocument($documentType, array $criteria = array())
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        $query->sort($this->getDefaultSort($documentType));
        return $query->one();
    }
    
    
    /**
     * Return an array containing informations about the last versions of all nodes
     */
    public function getNodesInLastVersion()
    {
        $repository = $this->documentsService->getRepository($this->getDocumentNamespace('Node'));
        
        $versions = $repository->getCollection()->aggregate(
            array(
                '$sort' => array('version' => -1),
            ),
            array(
                '$group' => array(
                    '_id' => '$nodeId',
                    'version' => array('$first' => '$version'),
                    'parentId' => array('$first' => '$parentId'),
                    'name' => array('$first' => '$name')
                )
            )
        );

        return $versions['result'];
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
                    'name' => array('$first' => '$name')
                )
            )
        );

        return $versions['result'];
    }
    
    
    /**
     * Get documentType model namespace
     * 
     * @param string $documentType
     */
    protected function getDocumentNamespace($documentType)
    {
        $documentNamespace = '';
        switch($documentType)
        {
            case 'Node':
                $documentNamespace = 'Model\PHPOrchestraCMSBundle\Node';
                break;
            case 'Template':
                $documentNamespace = 'Model\PHPOrchestraCMSBundle\Template';
                break;
            case 'Block':
                $documentNamespace = 'Model\PHPOrchestraCMSBundle\Block';
                break;
            default:
                throw new UnrecognizedDocumentTypeException('Unrecognized document type : ' . $documentType);
                break;
        }
        return $documentNamespace;
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
                break;
        }
        return $sort;
    }
}
