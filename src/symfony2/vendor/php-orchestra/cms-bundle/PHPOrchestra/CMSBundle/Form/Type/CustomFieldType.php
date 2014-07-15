<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Email;
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
        
        if (!isset($options['data'])
            || !isset($options['data']->type)
            || !isset($options['data']->symfonyType)
        ) {
            throw new UnknownFieldTypeException('No data or incomplete data');
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
        $builder
            ->add(
                'removeField',
                'checkbox',
                array(
                    'required' => false,
                    'label' => 'contentTypes.form.removeField',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add(
                'fieldId',
                'text',
                array(
                    'label' => 'contentTypes.form.identifier',
                    'translation_domain' => 'backOffice',
                    'constraints' => array(new NotBlank(), new Type('string'))
                )
            )
            ->add(
                'label',
                'multilingualText',
                array(
                    'label' => 'contentTypes.form.fieldLabel',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add(
                'defaultValue',
                'text',
                array(
                    'label' => 'contentTypes.form.defaultValue',
                    'translation_domain' => 'backOffice',
                    'required' => false,
                    'constraints' => $this->getConstraints($options['data']->symfonyType)
                )
            )
            ->add(
                'searchable',
                'checkbox',
                array(
                    'required' => false,
                    'label' => 'contentTypes.form.indexable',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add('symfonyType', 'hidden', array('data' => $parameters['type']));
        
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
                'translation_domain' => 'orchestraFields',
                'required' => $option['required']
            );
            
            $builder->add('option_' . $optionName, $option['type'], $fieldParams);
        }
    }

    /**
     * Get specific constraint depending on the field type
     * 
     * @param string $fieldType
     */
    public function getConstraints($fieldType)
    {
        $constraints = array();
        
        switch ($fieldType) {
            case 'integer':
                $constraints[] = new Type(array('type' => 'numeric'));
                break;
            case 'email':
                $constraints[] = new Email();
                break;
            default:;
        }
        
        return $constraints;
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
