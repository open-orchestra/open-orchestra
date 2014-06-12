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

    public function __construct($documentManager)
    {
        $this->documentManager = $documentManager;
    }

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
                }
                $fieldOptions['label'] = $field->label;
                $builder->add($field->fieldId, $field->symfonyType, $fieldOptions);
            }
        }
    }

    /**
     * getName
     */
    public function getName()
    {
        return 'contentAttributes';
    }
}
