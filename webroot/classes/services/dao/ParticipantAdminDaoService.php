<?php

interface ParticipantAdminDaoService {
	
	/**
	 * Stores the given new participant to the event referenced in it.
	 * Returns the id of the new participant
	 * 
	 * @param Participant $participant
	 * @return int
	 */
	public function createParticipant(Participant $participant);
	
	/**
	 * Updates the given participant.
	 * 
	 * @param Participant $participant
	 */
	public function updateParticipant(Participant $participant);
	
	/**
	 * Removes the given participant.
	 * 
	 * @param Participant $participant
	 */
	public function removeParticipant(Participant $participant);
	
}
