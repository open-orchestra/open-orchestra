<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Model\PHPOrchestraCMSBundle\ContentType;

class ContentTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Label du type de contenu'))
            ->add('contentTypeId', 'text', array('label' => 'Identifiant'))
            ->add('version', 'text', array('read_only' => true))
            ->add('status', 'choice', array('choices' => array(ContentType::STATUS_DRAFT => ContentType::STATUS_DRAFT, ContentType::STATUS_PUBLISHED => ContentType::STATUS_PUBLISHED)))
            ->add('id', 'hidden', array('mapped' => false, 'data' => (string)$options['data']->getId()))
            ->add('fields', 'textarea', array(
                'attr' => array('style' => 'width:500px !important;height:100px !important;'),
                'data' => $options['data']->getFields()
            ));
        
        $customFields = json_decode($options['data']->getFields());
        
        foreach ($customFields as $key => $customField) {
            $builder->add('customField' . $key, 'orchestra_customField', array('mapped' => false, 'data' => $customField));
        }
        
        $builder->add('cancel', 'button', array('attr' => array('class' => 'cancelButton')));
        $builder->add('save', 'button', array('attr' => array('class' => 'saveButton')));
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'contentType';
    }
}
