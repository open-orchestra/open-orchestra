<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use PHPOrchestra\CMSBundle\Form\DataTransformer\CustomFieldTransformer;
use PHPOrchestra\CMSBundle\Exception\UnknownFieldTypeException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomFieldType extends AbstractType
{
    protected $availableFields = null;

    /**
     * Constructor
     * 
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->availableFields = $container->getParameter('php_orchestra.custom_types');
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new CustomFieldTransformer();
        $builder->addModelTransformer($transformer);
        
        if (!isset($options['data']) || !isset($options['data']->type)) {
            throw new UnknownFieldTypeException('No data');
        }
        
        if (!isset($this->availableFields[$options['data']->type])) {
            throw new UnknownFieldTypeException('Unknown field type : ' . $options['data']->type);
        }
        
        $parameters = $this->availableFields[$options['data']->type];
        
        if (!isset($parameters['type'])) {
            throw new UnknownFieldTypeException('Missconfiguration on field type ' . $options['data']->type);
        }
        
        if (!isset($parameters['options']) || !is_array($parameters['options'])) {
            throw new UnknownFieldTypeException('Field type not described : ' . $options['data']->type);
        }
        
        $builder->add('label', 'multilingualText')
            ->add('fieldId', 'text', array('label' => 'Identifiant technique'))
            ->add('defaultValue', 'text', array('label' => 'Valeur par défaut', 'required' => false))
            ->add('searchable', 'checkbox', array('required' => false, 'label' => 'Indexable'))
            ->add('symfonyType', 'hidden', array('data' => $parameters['type']))
            ->add('removeField', 'checkbox', array('required' => false, 'label' => 'Supprimer le champ'));
        
        $optionsValues = (object) array();
        if (isset($options['data']->options)) {
            $optionsValues = $options['data']->options;
        } else {
            $options['data']->options = $optionsValues;
        }
        
        foreach ($parameters['options'] as $optionName => $option) {
            if (!property_exists($optionsValues, $optionName)) {
                $options['data']->options->$optionName = $option['default_value'];
            }
            $fieldParams = array(
                'label' => $option['label'],
                'required' => $option['required']
            );
            
            $builder->add('option_' . $optionName, $option['type'], $fieldParams);
        }
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'orchestra_customField';
    }
}
