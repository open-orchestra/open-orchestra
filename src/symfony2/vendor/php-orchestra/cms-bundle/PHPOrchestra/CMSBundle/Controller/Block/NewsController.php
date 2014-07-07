<?php
namespace PHPOrchestra\CMSBundle\Controller\Block;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPOrchestra\CMSBundle\Model\Area;
use PHPOrchestra\CMSBundle\Model\ContentRepository;

/**
 * Description of NewsController
 * this controller allow to show all news content
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */

class NewsController extends Controller
{
    
    public function showAction()
    {
        $allNews = $this->get('mandango')->getRepository('Model\PHPOrchestraCMSBundle\Content')->getAllNews();
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/News:show.html.twig',
            array('allNews' => $allNews)
        );

        return $response;
    }
    
    public function showBackAction()
    {
        $allNews = $this->get('mandango')->getRepository('Model\PHPOrchestraCMSBundle\Content')->getAllNews();
        
        $response = $this->render(
            'PHPOrchestraCMSBundle:Block/News:show.html.twig',
            array('allNews' => $allNews)
        );

        return $response;
    }
}
