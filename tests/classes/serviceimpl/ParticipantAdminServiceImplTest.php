<?php

class ParticipantAdminServiceImplTest extends ServiceImplTestBase {
	
	private function createParticipantDao(Event $event, $startId = null) {
		$players = array(
			new Player(is_null($startId)?null:$startId++, 'Player One', null, null),
			new Player(is_null($startId)?null:$startId++, 'Player Two', 'player@example.org', '+36305551234'),
		);
		return new Participant(is_null($startId)?null:$startId++,
			$event, $players, $players[0], $players[1], $players[0],
			12, 'Car type 42', 'ABC 123', 'hu', 1, null,
			Timestamp::parse('2013-12-26 12:00:00')
		);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsNormalUserForOpenRegistrationEvent() {
		$testdata = array(
			"INSERT INTO participant ( fk_event, reg_number, car_type, car_reg_number, country, additional_guests, comment, date )  VALUES ( 3, 12, 'Car type 42', 'ABC 123', 'hu', 1, null, '2013-12-26 12:00:00' ) " => 1,
			"INSERT INTO player ( fk_participant, name, email, phone )  VALUES ( 1, 'Player One', null, null ) " => 2,
			"INSERT INTO player ( fk_participant, name, email, phone )  VALUES ( 1, 'Player Two', 'player@example.org', '+36305551234' ) " => 3,
			"UPDATE participant SET fk_driver=2, fk_technical_driver=2, fk_navigator=3 WHERE (id=1)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event);
		$id = $impl->createParticipant($this->userNormal, $participant);
		$this->assertEquals(1, $id);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function createParticipantAsNormalUserForClosedRegistrationEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
	
		$event = $this->createEvent($this->geo2);
		$participant = $this->createParticipantDao($event);
		$impl->createParticipant($this->userNormal, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function createParticipantAsNormalUserForClosedEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
	
		$event = $this->createEvent($this->geo1);
		$participant = $this->createParticipantDao($event);
		$impl->createParticipant($this->userNormal, $participant);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsAdminUserForClosedRegistrationEvent() {
		$testdata = array(
			"INSERT INTO participant ( fk_event, reg_number, car_type, car_reg_number, country, additional_guests, comment, date )  VALUES ( 2, 12, 'Car type 42', 'ABC 123', 'hu', 1, null, '2013-12-26 12:00:00' ) " => 1,
			"INSERT INTO player ( fk_participant, name, email, phone )  VALUES ( 1, 'Player One', null, null ) " => 2,
			"INSERT INTO player ( fk_participant, name, email, phone )  VALUES ( 1, 'Player Two', 'player@example.org', '+36305551234' ) " => 3,
			"UPDATE participant SET fk_driver=2, fk_technical_driver=2, fk_navigator=3 WHERE (id=1)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
	
		$event = $this->createEvent($this->geo2);
		$participant = $this->createParticipantDao($event);
		$impl->createParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function createParticipantAsAdminUserForClosedEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
	
		$event = $this->createEvent($this->geo1);
		$participant = $this->createParticipantDao($event);
		$impl->createParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function updateParticipantAsAdminUserForClosedEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo1);
		$participant = $this->createParticipantDao($event);
		$impl->updateParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantAsAdminUserForClosedRegistrationEvent() {
		$testdata = array(
			"UPDATE participant SET fk_driver=null, fk_navigator=null, fk_technical_driver=null WHERE (id=4)" => true,
			"DELETE FROM player WHERE (fk_participant=4) AND (not (id in ('2,3')))" => true,
			"UPDATE participant SET reg_number=12, car_type='Car type 42', car_reg_number='ABC 123', country='hu', additional_guests=1, comment=null, fk_driver=2, fk_technical_driver=2, fk_navigator=3 WHERE (id=4)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo2);
		$participant = $this->createParticipantDao($event,2);
		$impl->updateParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantAsAdminUserForOpenEvent() {
		$testdata = array(
			"UPDATE participant SET fk_driver=null, fk_navigator=null, fk_technical_driver=null WHERE (id=4)" => true,
			"DELETE FROM player WHERE (fk_participant=4) AND (not (id in ('2,3')))" => true,
			"UPDATE participant SET reg_number=12, car_type='Car type 42', car_reg_number='ABC 123', country='hu', additional_guests=1, comment=null, fk_driver=2, fk_technical_driver=2, fk_navigator=3 WHERE (id=4)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event,2);
		$impl->updateParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function updateParticipantAsNormalUserForOpenEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event,2);
		$impl->updateParticipant($this->userNormal, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function deleteParticipantAsAdminUserForClosedEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo1);
		$participant = $this->createParticipantDao($event);
		$impl->removeParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipantAsAdminUserForClosedRegistrationEvent() {
		$testdata = array(
			"UPDATE participant SET fk_driver=null, fk_navigator=null, fk_technical_driver=null WHERE (id=4)" => true,
			"DELETE FROM player WHERE (fk_participant=4)" => true,
			"DELETE FROM participant WHERE (id=4)" => true
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo2);
		$participant = $this->createParticipantDao($event,2);
		$impl->removeParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipantAsAdminUserForOpenEvent() {
		$testdata = array(
			"UPDATE participant SET fk_driver=null, fk_navigator=null, fk_technical_driver=null WHERE (id=4)" => true,
			"DELETE FROM player WHERE (fk_participant=4)" => true,
			"DELETE FROM participant WHERE (id=4)" => true
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event,2);
		$impl->removeParticipant($this->userAdmin, $participant);
	}

	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function deleteParticipantAsNormalUserForOpenEvent() {
		$testdata = array();
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event);
		$impl->removeParticipant($this->userNormal, $participant);
	}
}
