<?php

interface ParticipantLoadDaoService {
	
	/**
	 * Returns the participants list for the given event.
	 * 
	 * @param Event $event
	 * @return array(Participant)
	 */
	public function loadParticipants(Event $event);
	
	/**
	 * Loads the participant by the given id for the given event.
	 * If no participant exists with the given id, throws an exception.
	 * 
	 * @param Event $event
	 * @param integer $participantId
	 * @return Participant
	 * @throws DaoException
	 */
	public function load(Event $event, $participantId);
	
}
