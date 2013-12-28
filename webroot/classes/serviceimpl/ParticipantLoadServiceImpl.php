<?php

class ParticipantLoadServiceImpl implements ParticipantLoadService {
	
	/**
	 * @var ParticipantAuthService
	 */
	private $participantAuthService;
	
	/**
	 * @var ParticipantLoadDaoService
	 */
	private $participantLoadDaoService;
	
	public function __construct(ParticipantAuthService $participantAuthService, ParticipantLoadDaoService $participantLoadDaoService) {
		$this->participantAuthService = $participantAuthService;
		$this->participantLoadDaoService = $participantLoadDaoService;
	}
	
	/**
	 * Returns the participants list for the given event.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return array(Participant)
	 * @throws DataAccessException
	 */
	public function loadParticipants(GeoUser $user, Event $event) {
		if (!$this->participantAuthService->canLoadParticipants($user, $event)) {
			throw new DataAccessException('cannot load participants for this event');
		}
		return $this->participantLoadDaoService->loadParticipants($event);
	}
	
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
	public function load(GeoUser $user, Event $event, $participantId) {
		$participant = $this->participantLoadDaoService->load($event, $participantId);
		if (!$this->participantAuthService->canLoad($user, $participant)) {
			throw new DataAccessException('no such participant with the given id for the event');
		} else {
			return $participant;
		}
	}
	
}

