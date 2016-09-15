<?php

namespace FormationBundle\Facade;

use JMS\Serializer\Annotation as JMS;
use OpenOrchestra\BaseApi\Facade\FacadeInterface;

class ApiClientFormationFacade implements FacadeInterface
{
    /** @JMS\Type("string") */
    public $clientId;

    /** @JMS\Type("string") */
    public $name;

    /** @JMS\Type("boolean") */
    public $trusted;

    /** @JMS\Type("string") */
    public $key;

    /** @JMS\Type("string") */
    public $secret;
}
