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
class BlockType extends AbstractType
{
	/**
	 * documentManager service
	 * @var documentManager
	 */
	protected $documentManager = null;

	/**
	 * filter values
	 */
	protected $filter = array();


	/**
	 * Constructor, require documentManager service
	 *
	 * @param $documentManager
	 */
	public function __construct($documentManager, $filter = array())
	{
		$this->documentManager = $documentManager;
		$this->filter = $filter;
	}

	/**
	 * Build Template form
	 *
	 * @param FormBuilderInterface $builder
	 * @param  array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		if($options['data']['is_node']){
			$builder->add('method',  'choice', array('attr' => array('class' => 'reload'), 'choices' => array(''=> '--------', 'generate' => 'Generate', 'load' => 'Load')));
			if(array_key_exists('method', $options['data'])){
				if($options['data']['method'] == 'load'){
					$builder->add('nodeId', 'orchestra_node_choice', array('attr' => array('class' => 'reload')));
					if(array_key_exists('nodeId', $options['data']) && $options['data']['nodeId'] != ''){
						$builder->add('blockId', new BlockChoiceType($options['data']['nodeId'], $this->documentManager, $this->filter), array('attr' => array('class' => 'used-as-label')));
					}
				}
				if($options['data']['method'] == 'generate'){
					$choices = array_map(function($value) { return $value['action']; }, $this->filter);
					$choices = array_flip($choices);
					$choices = array_merge(array('' => '--------'), $choices);
					$builder->add('component',  'choice', array('attr' => array('class' => 'reload used-as-label'), 'choices' => $choices));
					if(array_key_exists('component', $options['data']) && $options['data']['component'] != ''){
						$type = array_filter($this->filter, function($value)  use ($options) { return $value['action'] == $options['data']['component']; });
						if(count($type) > 0){
							$type = each($type);
							$type = $type['value']['form'];
							$builder->add('attributs', new $type());
						}
					}
				}
			}
		}
        else{
            $builder->add('nodeId', 'orchestra_node_choice', array('attr' => array('class' => 'reload')));
            if(array_key_exists('nodeId', $options['data']) && $options['data']['nodeId'] != ''){
                $builder->add('blockId', new BlockChoiceType($options['data']['nodeId'], $this->documentManager, $this->filter), array('attr' => array('class' => 'used-as-label')));
            }
        }
        $builder->addEventListener(FormEvents::POST_SUBMIT, function ($event) {
            $event->stopPropagation();
        }, 900);
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
		$view->vars['js'] = $options['js'];
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
                'js' => '',
                'data' => array('method_' => false)
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
