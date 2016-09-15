<?php

namespace FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OpenOrchestra\BaseApiBundle\Controller\Annotation as Api;

/**
 * Class DefaultController
 * @Api\Serialize()
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        $apiClients = $this->get('open_orchestra_api.repository.api_client')->findAll();

        return $this->get('open_orchestra_api.transformer_manager')->get('api_client_collection_formation')->transform($apiClients);
    }
}
