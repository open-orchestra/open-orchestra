<?php

namespace FormationBundle\Facade;

use OpenOrchestra\BaseApi\Facade\FacadeInterface;
use JMS\Serializer\Annotation as JMS;

class ApiClientCollectionFormationFacade implements FacadeInterface
{
    /**
     * @JMS\Type("array<FormationBundle\Facade\ApiClientFormationFacade>")
     */
    public $apiClients = array();
}
