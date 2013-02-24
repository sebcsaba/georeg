<?php

class ParticipantLoadServiceImplTest extends ServiceImplTestBase {
	
	private $player10, $player11;
	private $participant1;
	
	public function setUp() {
		parent::setUp();
		$this->player10 = array(
			'id'=>10,
			'fk_participant'=>2,
			'name'=>'Player ten',
			'email'=>null,
			'phone'=>null
		);
		$this->player11 = array(
			'id'=>11,
			'fk_participant'=>2,
			'name'=>'Player eleven',
			'email'=>'player.eleven@example.org',
			'phone'=>'+12345556789'
		);
		$this->participant1 = array(
			'id'=>2,
			'fk_event'=>1,
			'fk_driver'=>10,
			'fk_navigator'=>11,
			'fk_technical_driver'=>10,
			'reg_number'=>12,
			'car_type'=>'Car type 42',
			'car_reg_number'=>'ABC 123',
			'country'=>'hu',
			'additional_guests'=>1,
			'comment'=>null,
			'date'=>Timestamp::parse('2013-12-26 12:00:00')
		);
	}
	
	/**
	 * @test
	 */
	public function loadParticipantsForEvent() {
		$testdata = array(
			"SELECT * FROM player WHERE (fk_participant IN (SELECT id FROM participant WHERE (fk_event=1)))" => array($this->player10, $this->player11),
			"SELECT * FROM participant WHERE (fk_event=1)" => array($this->participant1),
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantLoadServiceImpl($db);
		
		$event = $this->createEvent($this->geo1);
		$participants = $impl->loadParticipants($event);
		$this->assertEquals(1, count($participants));
	}
	
	/**
	 * @test
	 */
	public function loadGivenParticipantForEvent() {
		$testdata = array(
			"SELECT * FROM participant WHERE (fk_event=1) AND (id=2)" => array($this->participant1),
			"SELECT * FROM player WHERE (fk_participant=2)" => array($this->player10, $this->player11),
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantLoadServiceImpl($db);
		
		$event = $this->createEvent($this->geo1);
		$participant = $impl->load($event, 2);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function loadNonexistentParticipantForEvent() {
		$testdata = array(
			"SELECT * FROM participant WHERE (fk_event=1) AND (id=13)" => array()
		);
		$db = TestDbEngine::createDatabase($this, $testdata);
		$impl = new ParticipantLoadServiceImpl($db);
		
		$event = $this->createEvent($this->geo1);
		$impl->load($event, 13);
	}
	
}
