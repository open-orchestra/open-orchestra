<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Model\PHPOrchestraCMSBundle\ContentType as ContentTypeModel;
use PHPOrchestra\CMSBundle\Form\DataTransformer\ContentTypeTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            ->add('id', 'hidden', array('mapped' => false, 'data' => (string)$options['data']->getId()))
            ->add(
                'contentTypeId',
                'text',
                array(
                    'label' => 'contentTypes.form.identifier',
                    'translation_domain' => 'backOffice',
                    'constraints' => new NotBlank()
                )
            )
            ->add(
                'name',
                'multilingualText',
                array(
                    'label' => 'contentTypes.form.label',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add(
                'version',
                'hidden',
                array(
                    'read_only' => true,
                    'label' => 'contentTypes.form.version',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add(
                'status',
                'choice',
                array(
                    'choices' => array(
                        ContentTypeModel::STATUS_DRAFT => ContentTypeModel::STATUS_DRAFT,
                        ContentTypeModel::STATUS_PUBLISHED => ContentTypeModel::STATUS_PUBLISHED
                    ),
                    'label' => 'contentTypes.form.status',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add('fields', 'contentTypeFields', array('data' => $options['data']->getFields()))
            ->add('new_field', 'hidden', array('label' => 'Nouveau champ', 'required' => false));
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
