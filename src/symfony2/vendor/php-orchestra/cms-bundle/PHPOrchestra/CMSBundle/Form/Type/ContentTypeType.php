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
use Model\PHPOrchestraCMSBundle\ContentType as ContentTypeModel;

class ContentTypeType extends AbstractType
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ContentTypeTransformer();
        $builder->addModelTransformer($transformer);
        
        $builder
            ->add('name', 'text', array('label' => 'Label du type de contenu'))
            ->add('contentTypeId', 'text', array('label' => 'Identifiant'))
            ->add('version', 'text', array('read_only' => true))
            ->add(
                'status',
                'choice',
                array(
                    'choices' => array(
                        ContentTypeModel::STATUS_DRAFT => ContentTypeModel::STATUS_DRAFT,
                        ContentTypeModel::STATUS_PUBLISHED => ContentTypeModel::STATUS_PUBLISHED
                    )
                )
            )
            ->add('id', 'hidden', array('mapped' => false, 'data' => (string)$options['data']->getId()))
            ->add('fields', 'hidden', array('data' => $options['data']->getFields()));
        
        $customFields = json_decode($options['data']->getFields());
        
        if (is_array($customFields)) {
            foreach ($customFields as $key => $customField) {
                $builder->add('customField_' . $key, 'orchestra_customField', array('data' => $customField));
            }
        }
        
        $builder
            ->add('new_field', 'orchestra_fieldSelect', array('label' => 'Nouveau champ', 'required' => false));
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'contentType';
    }
}
