<?php

interface EventLoadService {
	
	/**
	 * Lists the events visible for the given user.
	 * For an admin user, it shows all the events.
	 * For a non-admin user, it shows all the open events.
	 * 
	 * @param GeoUser $user
	 * @return array(Event)
	 */
	public function listEvents(GeoUser $user);
	
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
	public function load(GeoUser $user, $eventId);
	
}
