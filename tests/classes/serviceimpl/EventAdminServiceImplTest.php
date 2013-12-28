<?php

class EventAdminServiceImplTest extends ServiceImplTestBase {
	
	/**
	 * @test
	 */
	public function createEventAsAdminUser() {
		$event = $this->createEventObject($this->geo3);
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canCreateEvent')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('EventAdminDaoService');
		$mockDao->expects($this->once())
			->method('createEvent')
			->with($this->equalTo($event))
			->will($this->returnValue(3));
		
		$impl = new EventAdminServiceImpl($mockAuth, $mockDao);
		$id = $impl->createEvent($this->userAdmin, $event);
		$this->assertEquals(3, $id);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function createEventAsNormalUser() {
		$event = $this->createEventObject($this->geo3);
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canCreateEvent')
			->with($this->equalTo($this->userNormal))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('EventAdminDaoService');
		$mockDao->expects($this->never())->method('createEvent');
		$impl = new EventAdminServiceImpl($mockAuth, $mockDao);
		$impl->createEvent($this->userNormal, $event);
	}
	
	/**
	 * @test
	 */
	public function removeEventAsAdminUser() {
		$event = $this->createEventObject($this->geo3);
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canRemoveEvent')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('EventAdminDaoService');
		$mockDao->expects($this->once())
			->method('removeEvent')
			->with($this->equalTo($event));
		
		$impl = new EventAdminServiceImpl($mockAuth, $mockDao);
		$impl->removeEvent($this->userAdmin, $event);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function removeEventAsNormalUser() {
		$event = $this->createEventObject($this->geo3);
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canRemoveEvent')
			->with($this->equalTo($this->userNormal))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('EventAdminDaoService');
		$mockDao->expects($this->never())->method('removeEvent');
		
		$impl = new EventAdminServiceImpl($mockAuth, $mockDao);
		$impl->removeEvent($this->userNormal, $event);
	}
	
	/**
	 * @test
	 */
	public function updateClosedRegistrationEventAsAdminUser() {
		$event = $this->createEventObject($this->geo2);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canUpdateEvent')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('EventAdminDaoService');
		$mockDao->expects($this->once())
			->method('updateEvent')
			->with($this->equalTo($newEvent));
		
		$impl = new EventAdminServiceImpl($mockAuth, $mockDao);
		$impl->updateEvent($this->userAdmin, $newEvent);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function updateClosedEventAsAdminUser() {
		$event = $this->createEventObject($this->geo1);
		$newEvent = new Event($event->getId(),
			$event->getName().'updated',
			$event->getEventDate(),
			$event->getRegistrationEnd(),
			$event->getInternational());
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canUpdateEvent')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('EventAdminDaoService');
		$mockDao->expects($this->never())->method('updateEvent');
		
		$impl = new EventAdminServiceImpl($mockAuth, $mockDao);
		$impl->updateEvent($this->userAdmin, $newEvent);
	}
	
}
