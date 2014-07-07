<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\Block;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Model\ContentRepository;

/**
 * Description of NewsController
 * this controller allow to generate a caroussel
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */

class SampleController extends Controller
{
    
   /**
    * Render the sampleblock for front
    *
    * @param array $elementsList array containing custom attributes
    * @param array $_page_parameters additional parameters extracted from url
    */
    public function showAction($title, $author, $news, $_page_parameters = array())
    {
        $datetime = time();
    
        $allNews = $this->get('mandango')->getRepository('Model\PHPOrchestraCMSBundle\Content')->getAllNews();

        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/Sample:show.html.twig',
            array(
                      'title' => $title,
                      'author' => $author,
                      'news' => $news,
                      'parameters' => $_page_parameters,
                      'datetime' => $datetime,
            )
        );

        $response->setPublic();
        $response->setSharedMaxAge(5);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * Render the sampleblock for back
     * 
     * @param array $elementsList array containing custom attributes
     */
    public function showBackAction($title, $author, $news)
    {
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Sample:showBack.html.twig',
            array(
                  'title' => $title,
                  'author' => $author,
                  'news' => $news
            )
        );
    }
}
