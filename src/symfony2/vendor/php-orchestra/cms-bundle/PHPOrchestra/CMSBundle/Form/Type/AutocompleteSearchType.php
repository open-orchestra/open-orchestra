<?php

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AutocompleteSearchType
 */
class AutocompleteSearchType extends AbstractType
{
    protected $url;
    protected $value;
    protected $class;

    /**
     * @param string      $url
     * @param string|null $value
     * @param string|null $class
     */
    public function __construct($url, $value = 'submit', $class = null)
    {
        $this->url = $url;
        $this->value = $value;
        $this->class = $class;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('terms', 'text', array(
            'attr' => array(
                'data-autocomplete-url' => $this->url,
                'data-min-length' => 4,
            )
        ));

        $builder->add($this->value, 'submit', array(
            'attr' => array('class' => $this->class,),
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'autocomplete_search';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }
}
