<?php

interface ParticipantAuthService {
	
	/**
	 * Determines if the given user can load the participants for the given event.
	 * 
	 * @param GeoUser
	 * @param Event $event
	 * @return boolean
	 */
	public function canLoadParticipants(GeoUser $user, Event $event);
	
	/**
	 * Determines if the given user can load the given participant.
	 * 
	 * @param GeoUser
	 * @param Participant $participant
	 * @return boolean
	 */
	public function canLoad(GeoUser $user, Participant $participant);
	
	/**
	 * Determines if the given user can create participant for the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canCreateParticipant(GeoUser $user, Event $event);
	
	/**
	 * Determines if the given user can update the given participant.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @return boolean
	 */
	public function canUpdateParticipant(GeoUser $user, Participant $participant);
	
	/**
	 * Determines if the given user can delete the given participant.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @return boolean
	 */
	public function canRemoveParticipant(GeoUser $user, Participant $participant);
	
}
