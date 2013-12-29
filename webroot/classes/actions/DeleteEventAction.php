<?php

class DeleteEventAction implements Action {
	
	/**
	 * @var EventLoadService
	 */
	private $eventLoadService;
	
	/**
	 * @var EventAdminService
	 */
	private $eventAdminService;
	
	public function __construct(EventLoadService $eventLoadService, EventAdminService $eventAdminService) {
		$this->eventLoadService = $eventLoadService;
		$this->eventAdminService = $eventAdminService;
	}
	
	public function serve(Request $request) {
		$eventId = $request->get('id');
		$event = $this->eventLoadService->load($request->getUser(), $eventId);
		$this->eventAdminService->removeEvent($request->getUser(), $event);
		return new PageForward('mainscreen', 'reloadLeftMenu');
	}
	
}
