<?php

interface EventAdminService {
	
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
	public function createEvent(GeoUser $user, Event $event);
	
	/**
	 * Updates the given event.
	 * If the current user has no right to update the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @throws Exception
	 */
	public function updateEvent(GeoUser $user, Event $event);
	
	/**
	 * Removes the given event.
	 * If the current user has no right to remove the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @throws Exception
	 */
	public function removeEvent(GeoUser $user, Event $event);
	
}
