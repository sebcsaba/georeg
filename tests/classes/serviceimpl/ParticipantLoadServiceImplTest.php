<?php

class ParticipantLoadServiceImplTest extends ServiceImplTestBase {
	
	/**
	 * @test
	 */
	public function loadParticipantsForEvent() {
		$event = $this->createEventObject($this->geo1);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canLoadParticipants')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('ParticipantLoadDaoService');
		$mockResponse = new stdClass();
		$mockDao->expects($this->once())
			->method('loadParticipants')
			->with($this->equalTo($event))
			->will($this->returnValue($mockResponse));
		$impl = new ParticipantLoadServiceImpl($mockAuth, $mockDao);
		$participants = $impl->loadParticipants($this->userAdmin, $event);
		$this->assertSame($mockResponse, $participants);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function cannotLoadParticipantsForEvent() {
		$event = $this->createEventObject($this->geo1);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canLoadParticipants')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('ParticipantLoadDaoService');
		$mockDao->expects($this->never())
			->method('loadParticipants');
		$impl = new ParticipantLoadServiceImpl($mockAuth, $mockDao);
		$impl->loadParticipants($this->userAdmin, $event);
	}
	
	/**
	 * @test
	 */
	public function loadGivenParticipantForEvent() {
		$event = $this->createEventObject($this->geo1);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canLoad')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('ParticipantLoadDaoService');
		$mockDao->expects($this->once())
			->method('load')
			->with($this->equalTo($event), 2)
			->will($this->returnValue($participant));
		$impl = new ParticipantLoadServiceImpl($mockAuth, $mockDao);
		$result = $impl->load($this->userAdmin, $event, 2);
		$this->assertSame($participant, $result);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function cannotLoadGivenParticipantForEvent() {
		$event = $this->createEventObject($this->geo1);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canLoad')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('ParticipantLoadDaoService');
		$mockResponse = new stdClass();
		$mockDao->expects($this->once())
			->method('load')
			->with($this->equalTo($event), 2)
			->will($this->returnValue($participant));
		$impl = new ParticipantLoadServiceImpl($mockAuth, $mockDao);
		$impl->load($this->userAdmin, $event, 2);
	}
	
	/**
	 * @test
	 * @expectedException DaoException
	 */
	public function loadNonexistentParticipantForEvent() {
		$event = $this->createEventObject($this->geo1);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->never())
			->method('canLoad');
		$mockDao = $this->getMock('ParticipantLoadDaoService');
		$mockResponse = new stdClass();
		$mockDao->expects($this->once())
			->method('load')
			->with($this->equalTo($event), 13)
			->will($this->throwException(new DaoException('no such id')));
		$impl = new ParticipantLoadServiceImpl($mockAuth, $mockDao);
		$impl->load($this->userAdmin, $event, 13);
	}
	
}
