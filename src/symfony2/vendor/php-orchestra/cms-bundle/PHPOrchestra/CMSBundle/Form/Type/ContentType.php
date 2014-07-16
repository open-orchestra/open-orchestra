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
    private $contextManager = null;

    /**
     * Constructor
     * 
     * @param object $contextManager
     */
    public function __construct($contextManager)
    {
        $this->contextManager = $contextManager;
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'shortName',
                'text',
                array(
                    'label' => 'contents.form.name',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add(
                'status',
                'choice',
                array(
                    'choices' => array(
                        Content::STATUS_DRAFT => Content::STATUS_DRAFT,
                        Content::STATUS_PUBLISHED => Content::STATUS_PUBLISHED,
                        Content::STATUS_UNPUBLISHED => Content::STATUS_UNPUBLISHED
                    ),
                    'label' => 'contents.form.version',
                    'translation_domain' => 'backOffice'
                )
            )
            ->add('version', 'hidden')
            ->add('language', 'hidden')
            ->add('contentId', 'hidden')
            ->add('contentType', 'hidden');
        
        if (isset($options['data']) && is_object($options['data'])) {
            
            if (method_exists($options['data'], 'getId')) {
                $builder->add('id', 'hidden', array('mapped' => false, 'data' => (string)$options['data']->getId()));
            }
            
            if (method_exists($options['data'], 'getAttributes') && isset($options['data']->contentTypeStructure)) {
                $attributes = $options['data']->getAttributes();
                $attributes->language = $this->contextManager->getCurrentLocale();
                
                $attributes->contentType = $options['data']->contentTypeStructure;
                
                $builder->add(
                    'attributes',
                    'contentAttributes',
                    array(
                        'label' => 'Attributs',
                        'data' => $attributes
                    )
                );
            }
        }
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'content';
    }
}
