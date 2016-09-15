<?php

namespace FormationBundle\Facade;

use OpenOrchestra\BaseApi\Facade\FacadeInterface;
use JMS\Serializer\Annotation as JMS;

class ApiClientCollectionFacade implements FacadeInterface
{
    /**
     * @JMS\Type("")
     */
    public $apiClients;

}