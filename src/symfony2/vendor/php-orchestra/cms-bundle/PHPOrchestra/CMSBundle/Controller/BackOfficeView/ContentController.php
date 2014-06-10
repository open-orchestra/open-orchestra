<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Controller\BackOfficeView;

use PHPOrchestra\CMSBundle\Controller\TableViewController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/content/{contentTypeId}")
 */
class ContentController extends TableViewController
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra\CMSBundle\Controller.TableViewController::init()
     */
    function init() {
        $this->setEntity('Content');
        $this->setCriteria(array('contentType' => $this->routeParameters['contentTypeId']));
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra\CMSBundle\Controller.TableViewController::setColumns()
     */
    public function setColumns(){
        $this->columns = array(
            array('name' => 'contentType', 'search' => 'text', 'label' => 'Type de contenu'),
            array('name' => 'shortName', 'search' => 'text', 'label' => 'Nom'),
            array('name' => 'language', 'search' => 'text', 'label' => 'Langue'),
            array('name' => 'version', 'search' => 'text', 'label' => 'Version'),
            array('name' => 'status', 'search' => 'text', 'label' => 'Statut'),
            array('name' => 'deleted', 'search' => 'text', 'label' => 'Supprimé'),
            array('button' =>'modify'),
            array('button' =>'delete')
       );
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/php-orchestra/cms-bundle/PHPOrchestra/CMSBundle/Controller/PHPOrchestra\CMSBundle\Controller.TableViewController::deleteEntity()
     */
    public function deleteEntity(Request $request, $id)
    {
        $documentManager = $this->get('phporchestra_cms.documentmanager');
        
        $content = $documentManager->getDocumentById('Content', $id);
        $contentId = $content->getContentId();
        $contentVersions = $documentManager->getDocuments('Content', array('contentId' => $contentId));
        
        foreach ($contentVersions as $contentVersion) {
            $contentVersion->markAsDeleted();
        }
        
        return $this->redirect(
            $this->generateUrlValue('catalog')
        );
    }
}
