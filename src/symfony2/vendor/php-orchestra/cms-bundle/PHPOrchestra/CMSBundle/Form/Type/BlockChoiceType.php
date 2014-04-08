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

class BlockChoiceType extends AbstractType
{

    public $choices = null;

    /**
     * Constructor, require mandango service
     * 
     * @param Mandango\Mandango $mandango
     */
    public function __construct(Mandango\Mandango $mandango, $nodeId, $filter = array())
    {
        $node = DocumentLoader::getDocument('Node', array('nodeId' => $nodeId), $mandango);
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
        return 'orchestra_block_choice';
    }
}
