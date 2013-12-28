<?php

class ParticipantAdminServiceImplTest extends ServiceImplTestBase {
	
	/**
	 * @test
	 */
	public function createParticipant() {
		$event = $this->createEventObject($this->geo3);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canCreateParticipant')
			->with($this->equalTo($this->userNormal))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('ParticipantAdminDaoService');
		$mockDao->expects($this->once())
			->method('createParticipant')
			->with($this->equalTo($participant))
			->will($this->returnValue(1));
		$impl = new ParticipantAdminServiceImpl($mockAuth, $mockDao);
		
		$id = $impl->createParticipant($this->userNormal, $participant);
		$this->assertEquals(1, $id);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function cannotCreateParticipant() {
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canCreateParticipant')
			->with($this->equalTo($this->userNormal))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('ParticipantAdminDaoService');
		$mockDao->expects($this->never())
			->method('createParticipant');
		$impl = new ParticipantAdminServiceImpl($mockAuth, $mockDao);
		
		$impl->createParticipant($this->userNormal, $participant);
	}
	
	/**
	 * @test
	 */
	public function updateParticipant() {
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canUpdateParticipant')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('ParticipantAdminDaoService');
		$mockDao->expects($this->once())
			->method('updateParticipant')
			->with($this->equalTo($participant));
		$impl = new ParticipantAdminServiceImpl($mockAuth, $mockDao);
		
		$impl->updateParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function cannotUpdateParticipant() {
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canUpdateParticipant')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('ParticipantAdminDaoService');
		$mockDao->expects($this->never())
			->method('updateParticipant');
		$impl = new ParticipantAdminServiceImpl($mockAuth, $mockDao);
		
		$impl->updateParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipant() {
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canRemoveParticipant')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('ParticipantAdminDaoService');
		$mockDao->expects($this->once())
			->method('removeParticipant')
			->with($this->equalTo($participant));
		$impl = new ParticipantAdminServiceImpl($mockAuth, $mockDao);
		
		$impl->removeParticipant($this->userAdmin, $participant);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function cannotDeleteParticipant() {
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$mockAuth = $this->getMock('ParticipantAuthService');
		$mockAuth->expects($this->once())
			->method('canRemoveParticipant')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('ParticipantAdminDaoService');
		$mockDao->expects($this->never())
			->method('removeParticipant');
		$impl = new ParticipantAdminServiceImpl($mockAuth, $mockDao);
		
		$impl->removeParticipant($this->userAdmin, $participant);
	}
	
}
