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


    /**
     * Get a content by id
     *
     * @param string $contentId
     * @return <\Mandango\Document\Document, NULL>
     */
    public function getOne($contentId)
    {
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\Content')->createQuery();
        $query->criteria(array('contentId' => $contentId));
        $content = $query->one();
        return $content;
    }
}
