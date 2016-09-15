<?php

namespace FormationBundle\Transformer;

use FormationBundle\Facade\ApiClientFormationFacade;
use OpenOrchestra\BaseApi\Model\ApiClientInterface;
use OpenOrchestra\BaseApi\Transformer\AbstractTransformer;

class ApiClientFormationTransformer extends AbstractTransformer
{
    /**
     * @param ApiClientInterface $apiClient
     */
    public function transform($apiClient)
    {
        /** @var ApiClientFormationFacade $facade */
        $facade = $this->newFacade();

        $facade->clientId = $apiClient->getId();
        $facade->key = $apiClient->getKey();
        $facade->name = $apiClient->getName();
        $facade->secret = $apiClient->getSecret();
        $facade->trusted = $apiClient->isTrusted();

        return $facade;
    }

    public function getName()
    {
        return 'api_client_formation';
    }

}