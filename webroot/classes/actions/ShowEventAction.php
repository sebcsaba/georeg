<?php

class ShowEventAction implements Action {

	/**
	 * @var EventLoadService
	 */
	private $eventLoadService;
	
	/**
	 * @var ParticipantLoadService
	 */
	private $participantLoadService;
	
	public function __construct(EventLoadService $eventLoadService, ParticipantLoadService $participantLoadService) {
		$this->eventLoadService = $eventLoadService;
		$this->participantLoadService = $participantLoadService;
	}
	
	public function serve(Request $request) {
		$id = $request->get('id');
		$event = $this->eventLoadService->load($request->getUser(), $id);
		$participants = $this->participantLoadService->loadParticipants($request->getUser(), $event);
		$request->setData('event', $event);
		$request->setData('participants', $participants);
		return new PageForward('event.application.form');
	}
	
}
