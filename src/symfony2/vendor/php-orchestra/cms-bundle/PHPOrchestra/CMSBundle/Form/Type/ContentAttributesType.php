<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Doctrine\ORM\Query\AST\Functions\SubstringFunction;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use PHPOrchestra\CMSBundle\Form\DataTransformer\ContentAttributesTransformer;

class ContentAttributesType extends AbstractType
{
    public function __construct(ContainerInterface $container)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ContentAttributesTransformer();
        $builder->addModelTransformer($transformer);
        
        $fields = json_decode($options['data']->contentType->getFields());
        
        if (count($fields) > 0) {
            foreach ($fields as $key => $field) {
                $builder->add($field->fieldId, substr($field->type, 10), (array) $field->options);
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
