<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use PHPOrchestra\CMSBundle\Form\DataTransformer\ContentTypeFieldsTransformer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContentTypeFieldsType extends AbstractType
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ContentTypeFieldsTransformer();
        $builder->addModelTransformer($transformer);
        
        if (isset($options['data'])) {
            $customFields = json_decode($options['data']);
            
            if (is_array($customFields)) {
                foreach ($customFields as $key => $customField) {
                    $builder->add('customField_' . $key, 'orchestra_customField', array('data' => $customField));
                }
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
        return 'contentTypeFields';
    }
}
