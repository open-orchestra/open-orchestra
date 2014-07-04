<?php

namespace PHPOrchestraSite\Bundle\Repository;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;


/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="email")
 */
class Contact
{
	protected $name;
	
	protected $mail;
	
	protected $message;
	

	public function getName()
	{
		return $this->name;
	}
	
	public function setName($name)
	{
		$this->name = name;
	}
	
	public function getMail()
	{
		return $this->mail;
	}
	
	public function setMail($mail)
	{
		$this->mail = $mail;
	}
	
	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}
}