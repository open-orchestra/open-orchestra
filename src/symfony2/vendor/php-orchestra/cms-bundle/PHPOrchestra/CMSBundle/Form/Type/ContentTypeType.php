<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use PHPOrchestra\CMSBundle\Form\DataTransformer\ContentTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Model\PHPOrchestraCMSBundle\ContentType;

class ContentTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ContentTypeTransformer();
        $builder->addModelTransformer($transformer);
        
        $builder
            ->add('name', 'text', array('label' => 'Label du type de contenu'))
            ->add('contentTypeId', 'text', array('label' => 'Identifiant'))
            ->add('version', 'text', array('read_only' => true))
            ->add('status', 'choice', array('choices' => array(ContentType::STATUS_DRAFT => ContentType::STATUS_DRAFT, ContentType::STATUS_PUBLISHED => ContentType::STATUS_PUBLISHED)))
            ->add('id', 'hidden', array('mapped' => false, 'data' => (string)$options['data']->getId()))
            ->add('fields', 'hidden', array('data' => $options['data']->getFields())
        );
        
        $customFields = json_decode($options['data']->getFields());
        
        foreach ($customFields as $key => $customField) {
            $builder->add('customField_' . $key, 'orchestra_customField', array('data' => $customField));
        }
        
        $builder
            ->add('new_field', 'orchestra_fieldSelect', array('required' => false))
            ->add('cancel', 'button', array('attr' => array('class' => 'cancelButton')))
            ->add('save', 'submit');
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'contentType';
    }
}
