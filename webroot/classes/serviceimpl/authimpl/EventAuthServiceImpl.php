<?php

class EventAuthServiceImpl implements EventAuthService {
	
	/**
	 * @var EventLoadDaoService
	 */
	private $eventLoadDaoService;
	
	public function __construct(EventLoadDaoService $eventLoadDaoService) {
		$this->eventLoadDaoService = $eventLoadDaoService;
	}
	
	/**
	 * Determines if the given user can list all the events,
	 * or only ones with open registration.
	 * 
	 * @param GeoUser $user
	 * @return boolean
	 */
	public function canListOnlyOpenRegistrationEvents(GeoUser $user) {
		return !$user->isAdmin();
	}
	
	/**
	 * Determines if the given user can access to the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canLoad(GeoUser $user, Event $event) {
		if ($user->isAdmin()) {
			return true;
		} else {
			return $event->isEventOpen();
		}
	}
	
	/**
	 * Determines if the given user can create new event.
	 * 
	 * @param GeoUser $user
	 * @return boolean
	 */
	public function canCreateEvent(GeoUser $user) {
		return $user->isAdmin();
	}
	
	/**
	 * Determines if the given user can update the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canUpdateEvent(GeoUser $user, Event $event) {
		if (!$user->isAdmin()) {
			return false;
		}
		$originalEvent = $this->eventLoadDaoService->load($event->getId());
		if ($originalEvent->getEventDate()->isBefore(new Timestamp())) {
			return false;
		}
		return true;
	}
	
	/**
	 * Determines if the given user can delete the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canRemoveEvent(GeoUser $user, Event $event) {
		return $user->isAdmin();
	}
	
}
