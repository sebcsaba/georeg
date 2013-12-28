<?php

class ParticipantAuthServiceImpl implements ParticipantAuthService {
	
	/**
	 * Determines if the given user can load the participants for the given event.
	 * 
	 * @param GeoUser
	 * @param Event $event
	 * @return boolean
	 */
	public function canLoadParticipants(GeoUser $user, Event $event) {
		return true;
	}
	
	/**
	 * Determines if the given user can load the given participant.
	 * 
	 * @param GeoUser
	 * @param Participant $participant
	 * @return boolean
	 */
	public function canLoad(GeoUser $user, Participant $participant) {
		return true;
	}
	
	/**
	 * Determines if the given user can create participant for the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return boolean
	 */
	public function canCreateParticipant(GeoUser $user, Event $event) {
		if (!$event->isEventOpen()) {
			return false;
		}
		if (!$user->isAdmin() && !$event->isRegistrationOpen()) {
			return false;
		}
		return true;
	}
	
	/**
	 * Determines if the given user can update the given participant.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @return boolean
	 */
	public function canUpdateParticipant(GeoUser $user, Participant $participant) {
		if (!$user->isAdmin()) {
			return false;
		}
		if (!$participant->getEvent()->isEventOpen()) {
			return false;
		}
		return true;
	}
	
	/**
	 * Determines if the given user can delete the given participant.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @return boolean
	 */
	public function canRemoveParticipant(GeoUser $user, Participant $participant) {
		if (!$user->isAdmin()) {
			return false;
		}
		if (!$participant->getEvent()->isEventOpen()) {
			return false;
		}
		return true;
	}
	
}
