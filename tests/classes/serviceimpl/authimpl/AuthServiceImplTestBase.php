<?php

abstract class AuthServiceImplTestBase extends DaoServiceImplTestBase {
	
	/**
	 * user entity, id=1, admin role
	 * @var GeoUser
	 */
	protected $userAdmin;
	
	/**
	 * user entity, id=2, no admin role
	 * @var unknown
	 */
	protected $userNormal;
	
	public function setUp() {
		parent::setUp();
		$this->userAdmin = new GeoUser(1, 'admin', true);
		$this->userNormal = new GeoUser(2, 'normal', false);
	}
	
}
