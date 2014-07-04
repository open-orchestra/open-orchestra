<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Nicolas ANNE <nicolas.anne@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PHPOrchestra\CMSBundle\Form\Type\BlockChoiceType;
use Symfony\Component\Form\FormEvents;
use PHPOrchestra\CMSBundle\Form\Type\Block;

class BlockType extends AbstractType
{
    /**
     * documentManager service
     * @var documentManager
     */
    protected $documentManager = null;

    /**
     * filters values
     */
    protected $filters = array();


    /**
     * Constructor, require documentManager service
     *
     * @param $documentManager
     */
    public function __construct($documentManager, $filters = array())
    {
        $this->documentManager = $documentManager;
        $this->filters = $filters;
    }

    /**
     * Build Block form
     *
     * @param FormBuilderInterface $builder
     * @param  array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (array_key_exists('is_node', $options['data']) && $options['data']['is_node']) {
            $builder->add(
                'method',
                'choice',
                array(
                    'attr' => array('class' => 'refresh'),
                    'choices' => array('generate' => 'Generate', 'load' => 'Load'),
                    'empty_value' => '--------'
                )
            );
            if (array_key_exists('method', $options['data'])) {
                if ($options['data']['method'] == 'load') {
                    $builder->add(
                        'nodeId',
                        'orchestra_node_choice',
                        array('attr' => array('class' => 'refresh'), 'empty_value' => '--------')
                    );
                    if (array_key_exists('nodeId', $options['data']) && $options['data']['nodeId'] != '') {
                        $builder->add(
                            'blockId',
                            new BlockChoiceType($this->documentManager, array(), $options['data']['nodeId']),
                            array('attr' => array('class' => 'used-as-label'), 'empty_value' => '--------')
                        );
                    }
                }
                if ($options['data']['method'] == 'generate') {
                    $builder->add(
                        'component',
                        new BlockChoiceType($this->documentManager, array(), 0, 1),
                        array('attr' => array('class' => 'refresh used-as-label'), 'empty_value' => '--------')
                    );
                    if (array_key_exists('component', $options['data']) && $options['data']['component'] != '') {
                        $type = new \ReflectionClass(
                            'PHPOrchestra\CMSBundle\Form\Type\Block\\'.$options['data']['component'].'Type'
                        );
                        $builder->add('attributs', $type->newInstance());
                    }
                }
            }
        } else {
            $builder->add(
                'nodeId',
                'orchestra_node_choice',
                array('attr' => array('class' => 'refresh'), 'empty_value' => '--------')
            );
            if (array_key_exists('nodeId', $options['data']) && $options['data']['nodeId'] != '') {
                $builder->add(
                    'blockId',
                    new BlockChoiceType($this->documentManager, array(), $options['data']['nodeId']),
                    array('attr' => array('class' => 'used-as-label'), 'empty_value' => '--------')
                );
            }
        }
    }

    /**
     * Add parameters to view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['inDialog'] = $options['inDialog'];
        $view->vars['subForm'] = $options['subForm'];
        $view->vars['beginJs'] = $options['beginJs'];
        $view->vars['endJs'] = $options['endJs'];
    }

    /**
     * @param array $options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                    'inDialog' => false,
                    'subForm' => false,
                    'beginJs' => array(),
                    'endJs' => array()
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blocks';
    }
}
