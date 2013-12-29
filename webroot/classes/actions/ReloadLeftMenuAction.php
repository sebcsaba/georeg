<?php

class ReloadLeftMenuAction implements Action {
	
	private $eventLoadService;
	
	public function __construct(EventLoadService $eventLoadService) {
		$this->eventLoadService = $eventLoadService;
	}
	
	public function serve(Request $request) {
		$request->setData('events', $this->eventLoadService->listEvents($request->getUser()));
		return new PageForward('leftmenu');
	}
	
}
