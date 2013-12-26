<?php

class EventAdminServiceImplTest extends ServiceImplTestBase {
	
	/**
	 * @test
	 */
	public function createEventAsAdminUser() {
		$testdata = array("INSERT INTO event ( name, event_date, registration_end, international )  VALUES ( 'geo3', '2030-12-31 00:00:00', '2030-12-30 00:00:00', 0 ) " => 3);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventAdminServiceImpl($db);
		$event = $this->createEvent($this->geo3);
		$id = $impl->createEvent($this->userAdmin, $event);
		$this->assertEquals(3, $id);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function createEventAsNormalUser() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventAdminServiceImpl($db);
		$event = $this->createEvent($this->geo3);
		$impl->createEvent($this->userNormal, $event);
	}
	
	/**
	 * @test
	 */
	public function removeEventAsAdminUser() {
		$testdata = array('DELETE FROM event WHERE (id=1)' => true);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEvent($this->geo1);
		$impl = new EventAdminServiceImpl($db);
		$impl->removeEvent($this->userAdmin, $event);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function removeEventAsNormalUser() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEvent($this->geo1);
		$impl = new EventAdminServiceImpl($db);
		$impl->removeEvent($this->userNormal, $event);
	}
	
	/**
	 * @test
	 */
	public function updateClosedRegistrationEventAsAdminUser() {
		$testdata = array(
			"SELECT event_date FROM event WHERE (id=2)"=>array(array('event_date'=>$this->geo2['event_date'])),
			"UPDATE event SET name='geo2updated', event_date='2030-12-01 00:00:00', registration_end='2013-12-03 00:00:00', international=0 WHERE (id=2)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEvent($this->geo2);
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
	public function updateClosedEventAsAdminUser() {
		$testdata = array("SELECT event_date FROM event WHERE (id=1)"=>array(array('event_date'=>$this->geo1['event_date'])));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEvent($this->geo1);
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
	public function updateEventAsNormalUser() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEvent($this->geo1);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$impl = new EventAdminServiceImpl($db);
		$impl->updateEvent($this->userNormal, $newEvent);
	}
	
}
