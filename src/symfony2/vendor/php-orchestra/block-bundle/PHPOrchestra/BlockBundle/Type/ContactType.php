<?php
namespace PHPOrchestra\BlockBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('Nom', 'text')
		->add('E-mail', 'email')
		->add('Sujet', 'text')
		->add('Message', 'textarea')
		->add('OK', 'submit');
	}

	public function getName()
	{
		return 'Contact';
	}
}