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
     * @param integer $contentId
     * @return <\Mandango\Document\Document, NULL>
     */
    public function getOne($contentId)
    {
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\Content')->createQuery();
        $query->criteria(array('contentId' => $contentId));
        $content = $query->one();
        return $content;
    }


    public function getAllToIndex()
    {
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\Content')->createQuery();
        $query->criteria(array('status' => 'published', 'deleted' => false));
        return $query->all();
    }
    
    /**
     * Get all content if the contentType is "news"
     *
     * @param none
     * @return list of news
     */
    public function getAllNews()
    {
        $query = $this->getMandango()->getRepository('Model\PHPOrchestraCMSBundle\Content')->createQuery();
        $query->criteria(
            array(
                'contentType'=> "news",
                'status'=> "published"
            )
        );
        $allNews = $query->all();
        return $allNews;
    }
}
