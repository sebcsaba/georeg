<?php

interface EventAdminDaoService {
	
	/**
	 * Creates a new event.
	 * Returns the id of the new event
	 * 
	 * @param Event $event
	 * @return int
	 */
	public function createEvent(Event $event);
	
	/**
	 * Updates the given event.
	 * 
	 * @param Event $event
	 */
	public function updateEvent(Event $event);
	
	/**
	 * Removes the given event.
	 * 
	 * @param Event $event
	 */
	public function removeEvent(Event $event);
	
}
