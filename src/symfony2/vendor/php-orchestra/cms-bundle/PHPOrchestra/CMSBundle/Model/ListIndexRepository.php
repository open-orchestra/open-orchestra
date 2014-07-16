<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\ListIndex bundle document repository.
 */
class ListIndexRepository extends \Model\PHPOrchestraCMSBundle\Base\ListIndexRepository
{


    /**
     * get all identifiant in mongodb
     * 
     * @return array nodeId|contentId
     */
    public function getAll()
    {
        //$query = $this->createQuery();
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\ListIndex')->createQuery();
        $contents = $query->all();
        return $contents;
    }


    /**
     * If there is a document ListIndex avec a NodeId or a ContentId equal to $docId remove it
     * 
     * @param string $docId
     */
    public function removeByDocId($docId)
    {
        $docRepository = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\ListIndex');

        $query1 = $docRepository->createQuery(array('nodeId' => $docId));
        $query2 = $docRepository->createQuery(array('contentId' => $docId));
        
        $doc1 = $query1->one();
        $doc2 = $query2->one();

        if ($doc1 !== null) {
            $docRepository->delete($doc1);
        } elseif ($doc2 !== null) {
            $docRepository->delete($doc2);
        }
    }
}
