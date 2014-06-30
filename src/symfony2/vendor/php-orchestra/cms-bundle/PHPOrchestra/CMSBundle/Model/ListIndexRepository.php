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
}
