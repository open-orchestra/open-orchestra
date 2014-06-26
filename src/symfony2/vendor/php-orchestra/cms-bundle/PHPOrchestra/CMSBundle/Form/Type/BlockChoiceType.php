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

class BlockChoiceType extends AbstractType
{

    public $choices = null;

    /**
     * Constructor, require documentManager service
     * 
     * @param $documentManager
     */
    public function __construct($documentManager, $filters = array(), $nodeId = 0)
    {
    	if($nodeId === 0){
    		foreach ($filters as $key => $filter) {
                $this->choices[$key] = $key;
            }
    	}
    	else{
	        $node = $documentManager->getDocument('Node', array('nodeId' => $nodeId));
	        $this->choices[''] = '--------';
	        $filters = array_map(function($value) { return $value['action']; }, $filters);
	        $filters = array_flip($filters);
	        $blocks = $node->getBlocks();
	        $intRank = 1;
	        foreach ($blocks as $block) {
	            $component = $block->getComponent();
	            if (array_key_exists($component, $filters)) {
	                $this->choices[$intRank] = $filters[$component];
	                $intRank++;
	            }
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
