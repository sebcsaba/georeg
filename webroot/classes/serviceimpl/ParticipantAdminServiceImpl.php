<?php

class ParticipantAdminServiceImpl implements ParticipantAdminService {

	/**
	 * @var ParticipantAuthService
	 */
	private $participantAuthService;
	
	/**
	 * @var ParticipantAdminDaoService
	 */
	private $participantAdminDaoService;
	
	public function __construct(ParticipantAuthService $participantAuthService, ParticipantAdminDaoService $participantAdminDaoService) {
		$this->participantAuthService = $participantAuthService;
		$this->participantAdminDaoService = $participantAdminDaoService;
	}
	
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
	public function createParticipant(GeoUser $user, Participant $participant) {
		if (!$this->participantAuthService->canCreateParticipant($user, $event)) {
			throw new DataAccessException('cannot create participant');
		}
		return $this->participantAdminDaoService->createParticipant($participant);
	}
	
	/**
	 * Updates the given participant.
	 * If the current user has no right to update the given participant, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @throws DataAccessException
	 */
	public function updateParticipant(GeoUser $user, Participant $participant) {
		if (!$this->participantAuthService->canUpdateParticipant($user, $participant)) {
			throw new DataAccessException('cannot update participant');
		}
		$this->participantAdminDaoService->updateParticipant($participant);
	}
	
	/**
	 * Removes the given participant.
	 * If the current user has no right to remove the given participant, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Participant $participant
	 * @throws DataAccessException
	 */
	public function removeParticipant(GeoUser $user, Participant $participant) {
		if (!$this->participantAuthService->canRemoveParticipant($user, $participant)) {
			throw new DataAccessException('cannot remove participant');
		}
		$this->participantAdminDaoService->removeParticipant($participant);
	}
	
}
