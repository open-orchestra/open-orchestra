<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Model\PHPOrchestraCMSBundle\Content;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shortName', 'text', array('label' => 'Nom de référence'))
            ->add('contentType', 'text', array('label' => 'Type de contenu', 'read_only' => 'true'))
            ->add('version', 'text', array('label' => 'Version', 'read_only' => true))
            ->add('language', 'text', array('label' => 'Language'))
            ->add(
                'status',
                'choice',
                array(
                    'choices' =>
                        array(
                            Content::STATUS_DRAFT => Content::STATUS_DRAFT,
                            Content::STATUS_PUBLISHED => Content::STATUS_PUBLISHED,
                            Content::STATUS_UNPUBLISHED => Content::STATUS_UNPUBLISHED
                    )
                )
            )
            ->add('id', 'hidden', array('mapped' => false, 'data' => (string)$options['data']->getId()));
            //embeddedsMany:attributes: {class: Model\PHPOrchestraCMSBundle\ContentAttribute}
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'content';
    }
}
