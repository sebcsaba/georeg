<?php

class EventLoadServiceImplTest extends ServiceImplTestBase {

	/**
	 * @test
	 */
	public function listAllEvents() {
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canListOnlyOpenRegistrationEvents')
			->with($this->equalTo($this->userAdmin))
			->will($this->returnValue(false));
		$mockDao = $this->getMock('EventLoadDaoService');
		$mockResponse = new stdClass();
		$mockDao->expects($this->once())
			->method('listEvents')
			->with(false)
			->will($this->returnValue($mockResponse));
		$impl = new EventLoadServiceImpl($mockAuth, $mockDao);
		$events = $impl->listEvents($this->userAdmin);
		$this->assertSame($mockResponse, $events);
	}
	
	/**
	 * @test
	 */
	public function listFilteredEvents() {
		$mockAuth = $this->getMock('EventAuthService');
		$mockAuth->expects($this->once())
			->method('canListOnlyOpenRegistrationEvents')
			->with($this->equalTo($this->userNormal))
			->will($this->returnValue(true));
		$mockDao = $this->getMock('EventLoadDaoService');
		$mockResponse = new stdClass();
		$mockDao->expects($this->once())
			->method('listEvents')
			->with(true)
			->will($this->returnValue($mockResponse));
		$impl = new EventLoadServiceImpl($mockAuth, $mockDao);
		$events = $impl->listEvents($this->userNormal);
		$this->assertSame($mockResponse, $events);
	}
	
	/**
	 * @test
	 */
	public function loadOpenEvent() {
		$mockAuth = $this->getMock('EventAuthService');
 		$mockAuth->expects($this->once())
 			->method('canLoad')
 			->with($this->equalTo($this->userNormal))
 			->will($this->returnValue(true));
		$mockDao = $this->getMock('EventLoadDaoService');
 		$mockResponse = $this->createEventObject($this->geo3);
 		$mockDao->expects($this->once())
 			->method('load')
 			->with(3)
 			->will($this->returnValue($mockResponse));
		$impl = new EventLoadServiceImpl($mockAuth, $mockDao);
		$event = $impl->load($this->userNormal, 3);
		$this->assertSame($mockResponse, $event);
	}
	
	/**
	 * @test
	 * @expectedException DataAccessException
	 */
	public function loadClosedEventAsNormalUser() {
		$mockAuth = $this->getMock('EventAuthService');
 		$mockAuth->expects($this->once())
 			->method('canLoad')
 			->with($this->equalTo($this->userNormal))
 			->will($this->returnValue(false));
		$mockDao = $this->getMock('EventLoadDaoService');
		$mockResponse = $this->createEventObject($this->geo1);
 		$mockDao->expects($this->once())
 			->method('load')
 			->with(1)
 			->will($this->returnValue($mockResponse));
		$impl = new EventLoadServiceImpl($mockAuth, $mockDao);
		$impl->load($this->userNormal, 1);
	}
	
	/**
	 * @test
	 * @expectedException DaoException
	 */
	public function loadNonExistentEvent() {
		$mockAuth = $this->getMock('EventAuthService');
 		$mockAuth->expects($this->never())
 			->method('canLoad');
		$mockDao = $this->getMock('EventLoadDaoService');
 		$mockResponse = $this->createEventObject($this->geo1);
 		$mockDao->expects($this->once())
 			->method('load')
 			->with(42)
 			->will($this->throwException(new DaoException('no such id')));
		$impl = new EventLoadServiceImpl($mockAuth, $mockDao);
		$impl->load($this->userNormal, 42);
	}
	
}
