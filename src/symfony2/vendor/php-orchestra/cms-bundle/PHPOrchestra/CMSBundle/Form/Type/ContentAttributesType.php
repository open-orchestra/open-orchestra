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
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fields = json_decode($options['data']->contentType->getFields());
        $transformer = new ContentAttributesTransformer($this->documentManager, $fields);
        $builder->addModelTransformer($transformer);
        
        if (count($fields) > 0) {
            foreach ($fields as $key => $field) {
                $fieldOptions = array();
                if (isset($field->options)) {
                    $fieldOptions = (array) $field->options;
                    if (isset($fieldOptions['max_length']) && $fieldOptions['max_length'] == 0) {
                        unset($fieldOptions['max_length']);
                    }
                }
                $fieldOptions['label'] = $field->label;
                $builder->add($field->fieldId, $field->symfonyType, $fieldOptions);
            }
        }
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'contentAttributes';
    }
}
