<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Classes;

use PHPOrchestra\CMSBundle\Exception\UnrecognizedDocumentTypeException;

class DocumentLoader
{
    /** 
    * Get a MongoDB document giving its type and search citerias
    * 
    * @param string $documentType
    * @param array $criteria
    * @param Mandango $mandangoService
    */
    static function getDocument($documentType, array $criteria, $mandangoService)
    {
        $repository = $mandangoService->getRepository(self::getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        $query->sort(self::getDefaultSort($documentType));
        return $query->one();
    }
    
    /** 
    * Get MongoDB documents giving their type and search citerias
    * 
    * @param string $documentType
    * @param array $criteria
    * @param Mandango $mandangoService
    */
    static function getDocuments($documentType, array $criteria, $mandangoService)
    {
        $repository = $mandangoService->getRepository(self::getDocumentNamespace($documentType));
        $query = $repository->createQuery();
        $query->criteria($criteria);
        return $query->all();
    }
    
    /**
     * Get documentType model namespace
     * 
     * @param string $documentType
     */
    protected static function getDocumentNamespace($documentType)
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
    protected static function getDefaultSort($documentType)
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
