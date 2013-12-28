<?php

class EventAuthServiceImplTest extends AuthServiceImplTestBase {

	private function getEventLoadDaoServiceMock($loadMethodInvoked = null, $returnValue = null) {
		$mockedMethods = array('listEvents','load');
		$mock = $this->getMock('EventLoadDaoService',$mockedMethods);
		$mock->expects($this->never())->method('listEvents');
		if (is_null($loadMethodInvoked)) {
			$mock->expects($this->never())->method('load');
		} else {
			$mock->expects($this->once())->method('load')
				->with($loadMethodInvoked)
				->will($this->returnValue($returnValue));
		}
		return $mock;
	}
	
	/**
	 * @test
	 */
	public function canListOnlyOpenRegistrationEventsAsAdminUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$result = $impl->canListOnlyOpenRegistrationEvents($this->userAdmin);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function canListOnlyOpenRegistrationEventsAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$result = $impl->canListOnlyOpenRegistrationEvents($this->userNormal);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function loadOpenRegistrationEventAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo3);
		$result = $impl->canLoad($this->userNormal, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function loadClosedRegistrationEventAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo2);
		$result = $impl->canLoad($this->userNormal, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function loadClosedEventAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canLoad($this->userNormal, $event);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function loadClosedEventAsAdminUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canLoad($this->userAdmin, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function createEventAsAdminUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$result = $impl->canCreateEvent($this->userAdmin);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function createEventAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$result = $impl->canCreateEvent($this->userNormal);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function updateClosedRegistrationEventAsAdminUser() {
		$event = $this->createEventObject($this->geo2);
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock(2, $event));
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$result = $impl->canUpdateEvent($this->userAdmin, $newEvent);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function updateClosedEventAsAdminUser() {
		$event = $this->createEventObject($this->geo1);
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock(1, $event));
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$result = $impl->canUpdateEvent($this->userAdmin, $newEvent);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function updateEventAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo1);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$result = $impl->canUpdateEvent($this->userNormal, $newEvent);
		$this->assertFalse($result);
	}
	
	/**
	 * @test
	 */
	public function removeEventAsAdminUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canRemoveEvent($this->userAdmin, $event);
		$this->assertTrue($result);
	}
	
	/**
	 * @test
	 */
	public function removeEventAsNormalUser() {
		$impl = new EventAuthServiceImpl($this->getEventLoadDaoServiceMock());
		$event = $this->createEventObject($this->geo1);
		$result = $impl->canRemoveEvent($this->userNormal, $event);
		$this->assertFalse($result);
	}
	
}
