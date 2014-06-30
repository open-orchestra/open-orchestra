<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\FieldIndex bundle document repository.
 */
class FieldIndexRepository extends \Model\PHPOrchestraCMSBundle\Base\FieldIndexRepository
{


    /**
     * get all fields and their type in mongodb
     *
     * @return array nodeId|contentId
     */
    public function getAll()
    {
        //$query = $this->createQuery();
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\FieldIndex')->createQuery();
        $fields = $query->all();
        return $fields;
    }
}
