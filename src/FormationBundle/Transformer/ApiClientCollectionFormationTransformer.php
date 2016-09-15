<?php

namespace FormationBundle\Transformer;

use OpenOrchestra\BaseApi\Transformer\AbstractTransformer;

class ApiClientCollectionFormationTransformer extends AbstractTransformer
{
    public function transform($apiClients)
    {
        $facade = $this->newFacade();

        foreach($apiClients as $apiClient) {
            $facade->apiClients[] = $this->getTransformer('api_client_formation')->transform($apiClient);
        }

        return $facade;
    }

    public function getName()
    {
        return 'api_client_collection_formation';
    }
}