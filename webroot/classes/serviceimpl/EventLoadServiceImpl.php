<?php

class EventLoadServiceImpl implements EventLoadService {
	
	/**
	 * @var EventAuthService
	 */
	private $eventAuthService;
	
	/**
	 * @var EventLoadDaoService
	 */
	private $eventLoadDaoService;
	
	public function __construct(EventAuthService $eventAuthService, EventLoadDaoService $eventLoadDaoService) {
		$this->eventAuthService = $eventAuthService;
		$this->eventLoadDaoService = $eventLoadDaoService;
	}
	
	/**
	 * Lists the events visible for the given user.
	 * For an admin user, it shows all the events.
	 * For a non-admin user, it shows all the open events.
	 * 
	 * @param GeoUser $user
	 * @return array(Event)
	 */
	public function listEvents(GeoUser $user) {
		$onlyOpenRegistration = $this->eventAuthService->canListOnlyOpenRegistrationEvents($user);
		return $this->eventLoadDaoService->listEvents($onlyOpenRegistration);
	}
	
	/**
	 * Loads the event by the given id.
	 * If the current user cannot see the given event, throws an exception.
	 * If no event exists with the given id, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param integer $eventId
	 * @return Event
	 * @throws DataAccessException
	 */
	public function load(GeoUser $user, $eventId) {
		$event = $this->eventLoadDaoService->load($eventId);
		if ($this->eventAuthService->canLoad($user, $event)) {
			return $event;
		} else {
			throw new DataAccessException('the given event is closed now');
		}
	}
	
}
