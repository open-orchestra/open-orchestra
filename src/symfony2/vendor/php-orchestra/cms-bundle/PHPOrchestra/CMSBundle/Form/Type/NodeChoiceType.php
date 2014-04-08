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
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToAreasTransformer;
use PHPOrchestra\CMSBundle\Classes\DocumentLoader;
use mandango;

class NodeChoiceType extends AbstractType
{

    public $choices = null;

    /**
     * Constructor, require mandango service
     * 
     * @param Mandango\Mandango $mandango
     */
    public function __construct(Mandango\Mandango $mandango = null)
    {
        $nodes = DocumentLoader::getDocuments('Node', array(), $mandango);
        $this->choices[''] = '--------';
        foreach ($nodes as $key => $node) {
            $this->choices[$node->getNodeId()] = $node->getName();
        }
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->choices,
        ));
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
