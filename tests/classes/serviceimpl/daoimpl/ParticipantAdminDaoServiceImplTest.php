<?php

class ParticipantAdminDaoServiceImplTest extends ServiceImplTestBase {
	
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
	public function createParticipantForOpenEvent() {
		$testdata = array(
			"INSERT INTO participant ( fk_event, reg_number, car_type, car_reg_number, country, additional_guests, comment, date )  VALUES ( 3, 12, 'Car type 42', 'ABC 123', 'hu', 1, null, '2013-12-26 12:00:00' ) " => 1,
			"INSERT INTO player ( fk_participant, name, email, phone )  VALUES ( 1, 'Player One', null, null ) " => 2,
			"INSERT INTO player ( fk_participant, name, email, phone )  VALUES ( 1, 'Player Two', 'player@example.org', '+36305551234' ) " => 3,
			"UPDATE participant SET fk_driver=2, fk_technical_driver=2, fk_navigator=3 WHERE (id=1)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminDaoServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event);
		$id = $impl->createParticipant($participant);
		$this->assertEquals(1, $id);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantForOpenEvent() {
		$testdata = array(
			"UPDATE participant SET fk_driver=null, fk_navigator=null, fk_technical_driver=null WHERE (id=4)" => true,
			"DELETE FROM player WHERE (fk_participant=4) AND (not (id in ('2,3')))" => true,
			"UPDATE participant SET reg_number=12, car_type='Car type 42', car_reg_number='ABC 123', country='hu', additional_guests=1, comment=null, fk_driver=2, fk_technical_driver=2, fk_navigator=3 WHERE (id=4)" => true,
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminDaoServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event,2);
		$impl->updateParticipant($participant);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipantForOpenEvent() {
		$testdata = array(
			"UPDATE participant SET fk_driver=null, fk_navigator=null, fk_technical_driver=null WHERE (id=4)" => true,
			"DELETE FROM player WHERE (fk_participant=4)" => true,
			"DELETE FROM participant WHERE (id=4)" => true
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantAdminDaoServiceImpl($db);
		
		$event = $this->createEvent($this->geo3);
		$participant = $this->createParticipantDao($event,2);
		$impl->removeParticipant($participant);
	}
	
}
