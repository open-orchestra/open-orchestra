<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use PHPOrchestra\CMSBundle\Form\DataTransformer\ContentAttributesTransformer;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class ContentAttributesType extends AbstractType
{
    protected $documentManager = null;

    /**
     * Constructor
     * 
     * @param $documentManager
     */
    public function __construct($documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (isset($options['data']) && isset($options['data']->contentType)) {
            $fields = $options['data']->contentType->getFields();
            
            if (isset($fields)) {
                $fields = json_decode($fields);
                $transformer = new ContentAttributesTransformer($this->documentManager, $fields);
                $builder->addModelTransformer($transformer);
                
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        if (isset($field->fieldId) && isset($field->symfonyType)) {
                            $fieldOptions = array();
                            if (isset($field->options)) {
                                $fieldOptions = (array) $field->options;
                                if (isset($fieldOptions['max_length']) && $fieldOptions['max_length'] == 0) {
                                    unset($fieldOptions['max_length']);
                                }
                            }
                            if (isset($field->label)) {
                                $fieldOptions['label'] = $field->label;
                            }
                            
                            $fieldOptions['constraints'] = $this->generateConstraints($field);
                            
                            $builder->add($field->fieldId, $field->symfonyType, $fieldOptions);
                        }
                    }
                }
            }
        }
    }

    /**
     * Generate constraints for a field
     * 
     * @param object $field
     */
    public function generateConstraints($field)
    {
        $options = (array) $field->options;
        $constraints = array();
        
        if (isset($options['max_length']) && $options['max_length'] > 0) {
            $constraints[] = new Length(array('max' => $options['max_length']));
        }
        if (isset($options['required']) && $options['required']) {
            $constraints[] = new NotBlank();
        }
        
        if ($field->symfonyType == 'email') {
            $constraints[] = new Email();
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
        return 'contentAttributes';
    }
}
