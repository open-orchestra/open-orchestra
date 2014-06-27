<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeChoiceType extends AbstractType
{

    public $choices = null;

    /**
     * Constructor, require documentManager service
     * 
     * @param $documentManager
     */
    public function __construct($documentManager)
    {
        $nodes = $documentManager->getNodesInLastVersion();
        foreach ($nodes as $node) {
            $this->choices[$node['_id']] = $node['name'];
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => $this->choices,
            )
        );
    }
    
    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'orchestra_node_choice';
    }
}
