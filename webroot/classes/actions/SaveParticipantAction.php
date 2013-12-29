<?php

class SaveParticipantAction implements Action {
	
	/**
	 * @var Config
	 */
	private $config;
	
	/**
	 * @var EventLoadService
	 */
	private $eventLoadService;
	
	/**
	 * @var ParticipantAdminService
	 */
	private $participantAdminService;
	
	public function __construct(
			Config $config,
			EventLoadService $eventLoadService,
			ParticipantAdminService $participantAdminService) {
		$this->config = $config;
		$this->eventLoadService = $eventLoadService;
		$this->participantAdminService = $participantAdminService;
	}
	
	public function serve(Request $request) {
		try {
			$this->validate($request);
		} catch (ValidationException $ex) {
			return new MessageForward($ex->getMessage());
		}
		$participant = $this->parseParticipant($request);
		if (is_null($participant->getId())) {
			$id = $this->participantAdminService->createParticipant($request->getUser(), $participant);
		} else {
			$this->participantAdminService->updateParticipant($request->getUser(), $participant);
			$id = $participant->getId();
		}
		$request->set('participant_id', $id);
		$request->set('id', $participant->getEvent()->getId());
		return new ActionForward('ShowEventAction');
	}
	
	private function validate(Request $request) {
		if (!preg_match('/^\d+$/', $request->get('event_id'))) throw new ValidationException('Hiányzik az esemény azonosítója!');
		$playerNames = $request->get('player_name');
		if (!count($playerNames) || !strlen($playerNames[0])) throw new ValidationException('Legalább egy versenyzőt meg kell adni!');

		$eventId = $request->get('event_id');
		$event = $this->eventLoadService->load($request->getUser(), $eventId);
		if ($event->getInternational()) {
			if (!in_array($request->get('country'), $this->config->get('application/countries'))) throw new ValidationException('Hibás országkód!');
		}
	}
	
	/**
	 * @param Request $request
	 * @return Participant
	 */
	private function parseParticipant(Request $request) {
		$eventId = $request->get('event_id');
		$event = $this->eventLoadService->load($request->getUser(), $eventId);
		
		$id = $request->get('id');
		if (strlen($id)==0) $id = null;
		
		$regNumber = $request->get('reg_number');
		if (strlen($regNumber)==0) $regNumber = null;
		
		$players = $this->parsePlayers($request);
		// TODO
		$driver = $navigator = $technicalDriver = $players[0];
		
		if ($event->getInternational()) {
			$country = $request->get('country');
			$additionalGuests = (int)$request->get('additional_guests');
		} else {
			$country = $this->config->get('application/default_country');
			$additionalGuests = 0;
		}
		
		return new Participant(null,
			$event,
			$players,
			$driver,
			$navigator,
			$technicalDriver,
			$regNumber,
			$request->get('car_type'),
			$request->get('car_reg_number'),
			$country,
			$additionalGuests,
			$request->get('comment'),
			new Timestamp());
	}
	
	/**
	 * @param Request $request
	 * @return array of Player
	 */
	private function parsePlayers(Request $request) {
		$result = array();
		foreach (array_keys($request->get('player_name')) as $idx) {
			$player = $this->parsePlayer($request, $idx);
			if (!is_null($player)) {
				$result[] = $player;
			}
		}
		return $result;
	}
	
	/**
	 * @param Request $request
	 * @return Player or null
	 */
	private function parsePlayer(Request $request, $idx) {
		$name = I($request->get('player_name'), $idx);
		$email = I($request->get('player_email'), $idx);
		$phone = I($request->get('player_phone'), $idx);
		if (strlen($name)) {
			return new Player(null, $name, $email, $phone);
		} else {
			return null;
		}
	}
	
}
