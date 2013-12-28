<?php

interface EventAuthService {
	
	/**
	 * Determines if the given user can list all the events,
	 * or only ones with open registration.
	 * 
	 * @param GeoUser $user
	 * @return boolean
	 */
	public function canListOnlyOpenRegistrationEvents(GeoUser $user);
	
	/**
	 * Determines if the given user can access to the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canLoad(GeoUser $user, Event $event);
	
	/**
	 * Determines if the given user can create new event.
	 * 
	 * @param GeoUser $user
	 * @return boolean
	 */
	public function canCreateEvent(GeoUser $user);
	
	/**
	 * Determines if the given user can update the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canUpdateEvent(GeoUser $user, Event $event);
	
	/**
	 * Determines if the given user can delete the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canRemoveEvent(GeoUser $user, Event $event);
	
}
