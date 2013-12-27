<?php

class EventLoadDaoServiceImplTest extends DaoServiceImplTestBase {

	/**
	 * @test
	 */
	public function listAllEvents() {
		$testdata = array('SELECT * FROM event ORDER BY event_date DESC'=>array($this->geo1, $this->geo2, $this->geo3));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadDaoServiceImpl($db);
		$events = $impl->listEvents(false);
		$this->assertEquals(3, count($events));
		$this->assertInstanceOf('Event', $events[0]);
	}
	
	/**
	 * @test
	 */
	public function listOpenEvents() {
		$testdata = array('SELECT * FROM event WHERE (event_date >= CURRENT_DATE()) ORDER BY event_date DESC'=>array($this->geo2, $this->geo3));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadDaoServiceImpl($db);
		$events = $impl->listEvents(true);
		$this->assertEquals(2, count($events));
		$this->assertInstanceOf('Event', $events[0]);
	}
	
	/**
	 * @test
	 */
	public function loadOpenRegistrationEvent() {
		$testdata = array('SELECT * FROM event WHERE (id=3) ORDER BY event_date DESC'=>array($this->geo3));
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadDaoServiceImpl($db);
		$event = $impl->load(3);
		$this->assertEquals('geo3', $event->getName());
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function loadNonExistentEvent() {
		$testdata = array('SELECT * FROM event WHERE (id=42) ORDER BY event_date DESC'=>array());
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new EventLoadDaoServiceImpl($db);
		$impl->load(42);
	}
	
}
