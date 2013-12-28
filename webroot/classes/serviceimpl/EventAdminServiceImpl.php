<?php

class EventAdminServiceImpl implements EventAdminService {
	
	/**
	 * @var EventAuthService
	 */
	private $eventAuthService;
	
	/**
	 * @var EventAdminDaoService
	 */
	private $eventAdminDaoService;
	
	public function __construct(EventAuthService $eventAuthService, EventAdminDaoService $eventAdminDaoService) {
		$this->eventAuthService = $eventAuthService;
		$this->eventAdminDaoService = $eventAdminDaoService;
	}
	
	/**
	 * Creates a new event.
	 * If the current has no right to create a new event, throws an exception.
	 * Returns the id of the new event
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return int
	 * @throws Exception
	 */
	public function createEvent(GeoUser $user, Event $event) {
		if (!$this->eventAuthService->canCreateEvent($user)) {
			throw new DataAccessException('cannot create event');
		}
		return $this->eventAdminDaoService->createEvent($event);
	}
	
	/**
	 * Updates the given event.
	 * If the current user has no right to update the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @throws Exception
	 */
	public function updateEvent(GeoUser $user, Event $event) {
		if (!$this->eventAuthService->canUpdateEvent($user, $event)) {
			throw new DataAccessException('cannot update event');
		}
		$this->eventAdminDaoService->updateEvent($event);
	}
	
	/**
	 * Removes the given event.
	 * If the current user has no right to remove the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @throws Exception
	 */
	public function removeEvent(GeoUser $user, Event $event) {
		if (!$this->eventAuthService->canRemoveEvent($user, $event)) {
			throw new DataAccessException('cannot remove event');
		}
		$this->eventAdminDaoService->removeEvent($event);
	}
	
}
