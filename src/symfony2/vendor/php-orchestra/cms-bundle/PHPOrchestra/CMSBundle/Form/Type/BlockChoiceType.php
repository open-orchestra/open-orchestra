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
use PHPOrchestra\CMSBundle\Form\DataTransformer\JsonToAreasTransformer;

class BlockChoiceType extends AbstractType
{

    public $choices = null;

    /**
     * Constructor, require documentLoader service
     * 
     * @param $documentLoader
     */
    public function __construct($documentLoader, $nodeId, $filter = array())
    {
        $node = $documentLoader->getDocument('Node', array('nodeId' => $nodeId));
        $this->choices[''] = '--------';
        
        foreach ($filter as $key => $configBlock) {
            $filter[$key] = $configBlock['action'];
        }
        $filter = array_flip($filter);
        $blocks = $node->getBlocks();
        $intRank = 1;
        foreach ($blocks as $block) {
            $component = $block->getComponent();
            if (array_key_exists($component, $filter)) {
                $this->choices[$intRank] = $filter[$component];
                $intRank++;
            }
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
        return 'orchestra_block_choice';
    }
}
