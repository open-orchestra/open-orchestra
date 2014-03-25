<?php
/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël Gilain <noel.gilain@businessdecision.com>
 */

namespace PHPOrchestra\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PHPOrchestra\CMSBundle\Form\DataTransformer\jsonToAreasTransformer;

class AreasType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new jsonToAreasTransformer();
    	$builder->addModelTransformer($transformer);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'showDialog' => false
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if($options['showDialog']){
	        $view->vars['dialog'] = '
	        <div class="dialog-areas" style="display:none;" title="Area">
	            <label for="areaId">Area id : </label><input type="text" name="areaId" id="areaId" value=""><br />
	            <label for="classes">Classes : </label><input type="text" name="classes" id="classes" value=""><br />
	            <label for="direction">Direction : </label><select name="boDirection" id="direction"><option value="h">horizontal</option><option value="v">vertical</option></select>
	        </div>
	        ';
        }
    }
    
    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'orchestra_areas';
    }
    
}