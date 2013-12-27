<?php

interface EventLoadDaoService {
	
	/**
	 * Lists the events.
	 * If the parameter is true, lists only event with open registration.
	 * 
	 * @param boolean $onlyOpenRegistration
	 * @return array(Event)
	 */
	public function listEvents($onlyOpenRegistration);
	
	/**
	 * Loads the event by the given id.
	 * If no event exists with the given id, throws an exception.
	 * 
	 * @param integer $eventId
	 * @return Event
	 * @throws DaoException
	 */
	public function load($eventId);
	
}
