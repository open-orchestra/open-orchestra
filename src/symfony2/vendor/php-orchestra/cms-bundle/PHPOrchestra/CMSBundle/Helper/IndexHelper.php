<?php

namespace PHPOrchestra\CMSBundle\Helper;
    
use Symfony\Component\DependencyInjection\Container;

/**
 * 
 * @author benjamin fouché <benjamin.fouche@buisinessdecision>
 *
 */
class IndexHelper
{

    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected $container;
    
    protected $solr = false;
    
    protected $elasticSearch = false;

    /**
     * Instantiate the container
     * 
     * @param Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->init();
    }


    /**
     * Initiate $solr and $elasticsearch
     */
    protected function init()
    {
        $index = $this->container->getParameter('indexation');
        if (is_array($index)) {
            foreach ($index as $ind) {
                if (strcmp($ind, 'solr') === 0) {
                    $this->solr = true;
                } elseif (strcmp($ind, 'elasticsearch') === 0) {
                    $this->elasticSearch = true;
                }
            }
        } elseif ($index !== null) {
            if (strcmp($index, 'solr') === 0) {
                $this->solr = true;
            } elseif (strcmp($index, 'elasticsearch') === 0) {
                $this->elasticSearch = true;
            }
        }
    }


    /**
     * call solr indexation and elasticsearch indexation
     * 
     * @param Node|Content $docs
     * @param string $docType Node or Content
     */
    public function index($docs, $docType)
    {
        if ($this->solr) {
            // Testing if solr is running and index the documents
            $indexSolr = $this->container->get('phporchestra_cms.indexsolr');

            if ($indexSolr->solrIsRunning()) {
                $indexSolr->slpitDoc($docs, $docType);
            } else {
                // If solr is not running save documentId in ListIndex mongo document
                if (is_array($docs)) {
                    foreach ($docs as $doc) {
                        $this->addListIndex($doc, $docType);
                    }
                } else {
                    $this->addListIndex($docs, $docType);
                }
            }
        }
        if ($this->elasticSearch) {
            var_dump('Nous n\'avons pas encore elasticsearch');
        }
    }


    /**
     * Call solr deleteIndex and elasticsearch deleteIndex
     * 
     * @param string $docId NodeId | ContentId
     */
    public function deleteIndex($docId)
    {
        if ($this->solr) {
            // Testing if solr is running and delete a document from the index
            $indexSolr = $this->container->get('phporchestra_cms.indexsolr');
            if ($indexSolr->solrIsRunning()) {
                $indexSolr->deleteIndex($docId);
                $this->container->get('mandango')
                ->getRepository('Model\PHPOrchestraCMSBundle\ListIndex')
                ->removeByDocId($docId);
            }
        }
        if ($this->elasticSearch) {
            var_dump('Nous n\'avons pas encore elasticsearch');
        }
    }



    /**
     * Create a ListIndex document and save it
     *
     * @param Node | Content $doc
     * @param string $docType Node or Content
     */
    public function addListIndex($doc, $docType)
    {
        $listindex = $this->container->get('mandango')->create('Model\PHPOrchestraCMSBundle\ListIndex');
        if ($docType === 'Node') {
            $listindex->setNodeId($doc->getNodeId());
            $listindex->save();
        } elseif ($docType === 'Content') {
            $listindex->setContentId($doc->getContentId());
            $listindex->save();
        }
    }


    public function getSolr()
    {
        return $this->solr;
    }


    public function getElasticSearch()
    {
        return $this->elasticSearch;
    }
}
