<?php

class ParticipantAuthServiceImplTest extends AuthServiceImplTestBase {
	
	/**
	 * @test
	 */
	public function loadParticipantsForEventAsNormalUser() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canLoadParticipants($this->userNormal, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function loadGivenParticipantForEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo1);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canLoad($this->userNormal, $participant);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsNormalUserForOpenRegistrationEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo3);
		$result = $impl->canCreateParticipant($this->userNormal, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsNormalUserForClosedRegistrationEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo2);
		$result = $impl->canCreateParticipant($this->userNormal, $event);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsNormalUserForClosedEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canCreateParticipant($this->userNormal, $event);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsAdminUserForClosedRegistrationEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo2);
		$result = $impl->canCreateParticipant($this->userAdmin, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function createParticipantAsAdminUserForClosedEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canCreateParticipant($this->userAdmin, $event);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantAsAdminUserForClosedEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo1);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canUpdateParticipant($this->userAdmin, $participant);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantAsAdminUserForClosedRegistrationEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canUpdateParticipant($this->userAdmin, $participant);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantAsAdminUserForOpenEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo3);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canUpdateParticipant($this->userAdmin, $participant);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function updateParticipantAsNormalUserForOpenEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo3);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canUpdateParticipant($this->userNormal, $participant);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipantAsAdminUserForClosedEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo1);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canRemoveParticipant($this->userAdmin, $participant);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipantAsAdminUserForClosedRegistrationEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo2);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canRemoveParticipant($this->userAdmin, $participant);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function deleteParticipantAsAdminUserForOpenEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo3);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canRemoveParticipant($this->userAdmin, $participant);
		$this->assertTrue($result);
	}

	/**
	 * @test
	 */
	public function deleteParticipantAsNormalUserForOpenEvent() {
		$impl = new ParticipantAuthServiceImpl();
		$event = $this->createEventObject($this->geo3);
		$participant = $this->createParticipantObject($event);
		$result = $impl->canRemoveParticipant($this->userNormal, $participant);
		$this->assertFalse($result);
	}
	
}
