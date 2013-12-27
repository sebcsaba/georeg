<?php

class DaoServiceBase {
	
	/**
	 * @var Database
	 */
	protected $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
}
