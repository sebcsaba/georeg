<?php

interface ParticipantAdminService {
	
	/**
	 * Stores the given new participant to the event referenced in it.
	 * If registration period is over, throws an exception.
	 * Returns the id of the new participant
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @return int
	 * @throws DataAccessException
	 */
	public function createParticipant(GeoUser $user, Participant $participant);
	
	/**
	 * Updates the given participant.
	 * If the current user has no right to update the given participant, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @throws DataAccessException
	 */
	public function updateParticipant(GeoUser $user, Participant $participant);
	
	/**
	 * Removes the given participant.
	 * If the current user has no right to remove the given participant, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @throws DataAccessException
	 */
	public function removeParticipant(GeoUser $user, Participant $participant);
	
}
