<?php

class EventAdminDaoServiceImplTest extends DaoServiceImplTestBase {
	
	/**
	 * @test
	 */
	public function createEvent() {
		$testdata = array("INSERT INTO event ( name, event_date, registration_end, international )  VALUES ( 'geo3', '2030-12-31 00:00:00', '2030-12-30 00:00:00', 0 ) " => 3);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventAdminDaoServiceImpl($db);
		$event = $this->createEventObject($this->geo3);
		$id = $impl->createEvent($event);
		$this->assertEquals(3, $id);
	}
	
	/**
	 * @test
	 */
	public function removeEvent() {
		$testdata = array('DELETE FROM event WHERE (id=1)' => true);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEventObject($this->geo1);
		$impl = new EventAdminDaoServiceImpl($db);
		$impl->removeEvent($event);
	}
	
	/**
	 * @test
	 */
	public function updateClosedRegistrationEvent() {
		$testdata = array("UPDATE event SET name='geo2updated', event_date='2030-12-01 00:00:00', registration_end='2013-12-03 00:00:00', international=0 WHERE (id=2)" => true);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$event = $this->createEventObject($this->geo2);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$impl = new EventAdminDaoServiceImpl($db);
		$impl->updateEvent($newEvent);
	}
	
}
