<?php

class GeoUser implements User {
	
	/**
	 * Identifier
	 * 
	 * @var integer
	 */
	private $id;
	
	/**
	 * Name
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * True, if this is an admin user
	 * 
	 * @var boolean
	 */
	private $admin;
	
	public function __construct($id, $name, $admin) {
		$this->id = $id;
		$this->name = $name;
		$this->admin = $admin;
	}
	
	/**
	 * Returns the id of the user
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Returns the name of the user
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns true, if this is an admin user
	 * 
	 * @return boolean
	 */
	public function isAdmin() {
		return $this->admin;
	}
	
}
