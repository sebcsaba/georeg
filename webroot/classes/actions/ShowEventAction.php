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
	
	/**
	 * @var EventAuthService
	 */
	private $eventAuthService;
	
	public function __construct(
			EventLoadService $eventLoadService,
			ParticipantLoadService $participantLoadService,
			EventAuthService $eventAuthService) {
		$this->eventLoadService = $eventLoadService;
		$this->participantLoadService = $participantLoadService;
		$this->eventAuthService = $eventAuthService;
	}
	
	public function serve(Request $request) {
		$id = $request->get('id');
		$event = $this->eventLoadService->load($request->getUser(), $id);
		$participants = $this->participantLoadService->loadParticipants($request->getUser(), $event);
		$request->setData('event', $event);
		$request->setData('participants', $participants);
		$request->setData('canModifyEvent', $this->eventAuthService->canUpdateEvent($request->getUser(), $event));
		return new PageForward('event.application.form', $request->get('response-call-javascript'));
	}
	
}
