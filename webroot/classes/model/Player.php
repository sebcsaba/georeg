<?php

class Player {
	
	/**
	 * Identifier
	 * 
	 * @var integer or null
	 */
	private $id;
	
	/**
	 * Name
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * Email
	 * 
	 * @var string or null
	 */
	private $email;
	
	/**
	 * Phone number
	 * 
	 * @var string or null
	 */
	private $phone;
	
	public function __construct($id, $name, $email, $phone) {
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
	}
	
	/**
	 * Returns the identifier
	 * 
	 * @return integer or null
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Returns the name
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the email
	 * 
	 * @return string or null
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * Returns the phone number
	 * 
	 * @return string or null
	 */
	public function getPhone() {
		return $this->phone;
	}
	
}
