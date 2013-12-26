<?php

class EventLoadServiceImplTest extends ServiceImplTestBase {

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
