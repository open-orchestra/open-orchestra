<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;

class OrchestraFieldSelectType extends AbstractType
{

    protected $availableFields = array('' => '---');

    public function __construct(ContainerInterface $container)
    {
        $availableFields = $container->getParameter('php_orchestra.custom_types');
        foreach ($availableFields as $fieldId => $field) {
            $this->availableFields[$fieldId] = $field['type'];
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('choices' => $this->availableFields));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'orchestra_fieldSelect';
    }
}
