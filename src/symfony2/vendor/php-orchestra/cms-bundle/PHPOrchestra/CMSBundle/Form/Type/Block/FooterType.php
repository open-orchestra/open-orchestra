<?php

/*
 * Business & Decision - Commercial License
*
* Copyright 2014 Business & Decision.
*
* All rights reserved. You CANNOT use, copy, modify, merge, publish,
* distribute, sublicense, and/or sell this Software or any parts of this
* Software, without the written authorization of Business & Decision.
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* See LICENSE.txt file for the full LICENSE text.
*/

namespace PHPOrchestra\CMSBundle\Form\Type\Block;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Menu form builder
 * 
 * @author benjamin fouche <benjamin.fouche@businessdecision.com>
 *
 */
class FooterType extends AbstractType
{
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('classFooter', 'textarea')
            ->add('idFooter', 'text');
    }
    
    /**
     * (non-PHPdoc)
     * @see src/symfony2/vendor/symfony/symfony/src/Symfony/Component/Form/Symfony
     * \Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'footer';
    }
}
