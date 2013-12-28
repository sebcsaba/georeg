<?php

interface ParticipantLoadService {
	
	/**
	 * Returns the participants list for the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return array(Participant)
	 * @throws DataAccessException
	 */
	public function loadParticipants(GeoUser $user, Event $event);
	
	/**
	 * Loads the participant by the given id for the given event.
	 * If no participant exists with the given id, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @param integer $participantId
	 * @return Participant
	 * @throws DataAccessException
	 */
	public function load(GeoUser $user, Event $event, $participantId);
	
}
