<?php

class ShowModifyEventAction implements Action {
	
	/**
	 * @var EventLoadService
	 */
	private $eventLoadService;
	
	public function __construct(EventLoadService $eventLoadService) {
		$this->eventLoadService = $eventLoadService;
	}
	
	public function serve(Request $request) {
		$eventId = $request->get('id');
		$event = $this->eventLoadService->load($request->getUser(), $eventId);
		$request->setData('event', $event);
		$request->setData('title', 'Verseny módosítása');
		return new PageForward('eventform');
	}
	
}
