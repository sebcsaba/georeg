<?php

class EventLoadServiceImplTest extends PHPUnit_Framework_TestCase {

	// event is closed
	private $geo1 = array('id'=>1, 'name'=>'geo1', 'event_date'=>'2013-12-02', 'registration_end'=>'2013-12-01', 'international'=>0);
	
	// event is open, registration is closed
	private $geo2 = array('id'=>2, 'name'=>'geo2', 'event_date'=>'2030-12-01', 'registration_end'=>'2013-12-03', 'international'=>0);
	
	// registration is open
	private $geo3 = array('id'=>3, 'name'=>'geo3', 'event_date'=>'2030-12-31', 'registration_end'=>'2030-12-30', 'international'=>0);
	
	private $userAdmin;
	private $userNormal;
	
	public function setUp() {
		$this->userAdmin = new GeoUser(1, 'admin', true);
		$this->userNormal = new GeoUser(2, 'normal', false);
	}
	
	/**
	 * @test
	 */
	public function listEventsForAdminUser() {
		$testdata = array('SELECT * FROM event ORDER BY event_date DESC'=>array($this->geo1, $this->geo2, $this->geo3));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$events = $impl->listEvents($this->userAdmin);
		$this->assertEquals(3, count($events));
	}
	
	/**
	 * @test
	 */
	public function listEventsForNonAdminUser() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) ORDER BY event_date DESC'=>array($this->geo2, $this->geo3));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$events = $impl->listEvents($this->userNormal);
		$this->assertEquals(2, count($events));
	}
	
	/**
	 * @test
	 */
	public function loadOpenRegistrationEventAsNormalUser() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) AND (id=3) ORDER BY event_date DESC'=>array($this->geo3));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$event = $impl->load($this->userNormal, 3);
		$this->assertEquals('geo3', $event->getName());
	}
	
	/**
	 * @test
	 */
	public function loadClosedRegistrationEventAsNormalUser() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) AND (id=2) ORDER BY event_date DESC'=>array($this->geo2));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$event = $impl->load($this->userNormal, 2);
		$this->assertEquals('geo2', $event->getName());
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function loadClosedEventAsNormalUser() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) AND (id=1) ORDER BY event_date DESC'=>array());
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$impl->load($this->userNormal, 1);
	}
	
	/**
	 * @test
	 */
	public function loadClosedEventAsAdminUser() {
		$testdata = array('SELECT * FROM event WHERE (id=1) ORDER BY event_date DESC'=>array($this->geo1));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$event = $impl->load($this->userAdmin, 1);
		$this->assertEquals('geo1', $event->getName());
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function loadNonExistentEvent() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) AND (id=42) ORDER BY event_date DESC'=>array());
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadServiceImpl($db);
		$impl->load($this->userNormal, 42);
	}
	
}
