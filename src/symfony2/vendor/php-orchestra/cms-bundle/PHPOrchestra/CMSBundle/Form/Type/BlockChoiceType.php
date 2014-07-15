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
    public function __construct($documentManager, $filters = array(), $nodeId = 0, $siteId = 0)
    {
        $this->choices = array();
        if (is_array($filters) && count($filters) > 0) {
            foreach ($filters as $filter) {
                $this->choices[$filter] = $filter;
            }
        } elseif ($nodeId !== 0) {
            $node = $documentManager->getDocument('Node', array('nodeId' => $nodeId));
            $blocks = $node->getBlocks();
            $intRank = 0;
            foreach ($blocks as $block) {
            	$attributs = $block->getAttributes();
            	$result = array();
            	array_walk_recursive($attributs, function($val, $key) use (&$result) {$result[] = $val;});
            	$result = implode(', ', $result);
            	$result = (strlen($result) > 50) ? substr($result, 0, 47).'...' : $result;
            	$result = ' ['.$result.']';
                $this->choices[$intRank] = $block->getComponent().$result;
                $intRank++;
            }
        } elseif ($siteId !== 0) {
            $site = $documentManager->getDocument('Site', array('siteId' => $siteId));
            $blocks = $site->getBlocks();
            foreach ($blocks as $block) {
                $this->choices[$block] = $block;
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
