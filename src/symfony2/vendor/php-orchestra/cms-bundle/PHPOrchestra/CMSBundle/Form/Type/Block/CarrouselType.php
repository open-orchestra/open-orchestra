<?php
namespace PHPOrchestra\CMSBundle\Form\Type\Block;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Model\PHPOrchestraCMSBundle\Content;

class CarrouselType extends AbstractType
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //pictures et un tableau d'image
        //à ma connaissance il n'existe aucun type pour cela
        ->add('pictures', 'textarea')
        ->add('width', 'text')
        ->add('height', 'text');
    }

    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'carrousel';
    }
}
