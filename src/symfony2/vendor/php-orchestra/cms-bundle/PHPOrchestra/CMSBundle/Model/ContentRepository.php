<?php

namespace PHPOrchestra\CMSBundle\Model;

/**
 * Model\PHPOrchestraCMSBundle\Content bundle document repository.
 */
class ContentRepository extends \Model\PHPOrchestraCMSBundle\Base\ContentRepository
{

    /**
     * Get all contents in mongodb
     *
     * @return list of contents
     */
    public function getAllContents()
    {
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\Content')->createQuery();
        $contents = $query->all();
        return $contents;
    }
}
