<?php

class EventAdminServiceImplTest extends PHPUnit_Framework_TestCase {
	
	private $geo1 = array('id'=>1, 'name'=>'geo1', 'event_date'=>'2013-12-02', 'registration_end'=>'2013-12-01', 'international'=>0);
	
	private $userAdmin;
	private $userNormal;
	
	public function setUp() {
		$this->userAdmin = new GeoUser(1, 'admin', true);
		$this->userNormal = new GeoUser(2, 'normal', false);
	}
	
	/**
	 * @test
	 */
	public function createEventForAdmin() {
		$testdata = array("INSERT INTO event ( name, event_date, registration_end, international )  VALUES ( 'geo13', '2030-12-29 00:00:00', '2030-12-31 00:00:00', 1 ) " => 13);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventAdminServiceImpl($db);
		$event = new Event(null, 'geo13', Timestamp::parse('2030-12-29'), Timestamp::parse('2030-12-31'), true);
		$id = $impl->createEvent($this->userAdmin, $event);
		$this->assertEquals(13, $id);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function createEventForNonAdmin() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventAdminServiceImpl($db);
		$event = new Event(null, 'geo13', Timestamp::parse('2030-12-29'), Timestamp::parse('2030-12-31'), true);
		$impl->createEvent($this->userNormal, $event);
	}
	
	/**
	 * @test
	 */
	public function removeEventForAdmin() {
		$testdata = array(
			'SELECT * FROM event WHERE (id=1) ORDER BY event_date DESC' => array($this->geo1),
			'DELETE FROM event WHERE (id=1)' => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$loader = new EventLoadServiceImpl($db);
		$event = $loader->load($this->userAdmin, 1);
		$impl = new EventAdminServiceImpl($db);
		$impl->removeEvent($this->userAdmin, $event);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function removeEventForNonAdmin() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) AND (id=1) ORDER BY event_date DESC' => array($this->geo1));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$loader = new EventLoadServiceImpl($db);
		$event = $loader->load($this->userNormal, 1);
		$impl = new EventAdminServiceImpl($db);
		$impl->removeEvent($this->userNormal, $event);
	}
	
	/**
	 * @test
	 */
	public function updateEventForAdmin() {
		$testdata = array(
			'SELECT * FROM event WHERE (id=1) ORDER BY event_date DESC' => array($this->geo1),
			"UPDATE event SET name='geo1updated', event_date='2013-12-02 00:00:00', registration_end='2013-12-01 00:00:00', international=0 WHERE (id=1)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$loader = new EventLoadServiceImpl($db);
		$event = $loader->load($this->userAdmin, 1);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$impl = new EventAdminServiceImpl($db);
		$impl->updateEvent($this->userAdmin, $newEvent);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function updateEventForNonAdmin() {
		$testdata = array(
			'SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) AND (id=1) ORDER BY event_date DESC' => array($this->geo1),
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$loader = new EventLoadServiceImpl($db);
		$event = $loader->load($this->userNormal, 1);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$impl = new EventAdminServiceImpl($db);
		$impl->updateEvent($this->userNormal, $newEvent);
	}
	
}
