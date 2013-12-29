<?php

class SaveEventAction implements Action {
	
	/**
	 * @var EventAdminService
	 */
	private $eventAdminService;
	
	public function __construct(EventAdminService $eventAdminService) {
		$this->eventAdminService = $eventAdminService;
	}
	
	public function serve(Request $request) {
		try {
			$this->validate($request);
		} catch (ValidationException $ex) {
			return new MessageForward($ex->getMessage());
		}
		$event = $this->parseEvent($request);
		if (is_null($event->getId())) {
			$id = $this->eventAdminService->createEvent($request->getUser(), $event);
		} else {
			$this->eventAdminService->updateEvent($request->getUser(), $event);
			$id = $event->getId();
		}
		$request->set('id', $id);
		$request->set('response-call-javascript', 'reloadLeftMenu');
		return new ActionForward('ShowEventAction');
	}
	
	private function validate(Request $request) {
		if (!strlen($request->get('name'))) throw new ValidationException('A név mezőt ki kell tölteni!');
		if (!$this->isDate($request->get('eventDate'))) throw new ValidationException('Hibás a verseny dátuma!');
		if (!$this->isDate($request->get('registrationEnd'))) throw new ValidationException('Hibás a nevezési határidő!');
		if (!$this->isTime($request->get('registrationEndTime'))) throw new ValidationException('Hibás a nevezési határidő!');
	}
	
	private function isDate($value) {
		try {
			Timestamp::parse($value);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	private function isTime($value) {
		return preg_match('/^ *(\d+):(\d+) *$/',$value);
	}
	
	/**
	 * @param Request $request
	 * @return Event
	 */
	private function parseEvent(Request $request) {
		$id = $request->get('id');
		if (strlen($id)==0) $id = null;
		
		$name = $request->get('name');
		$international = $request->has('international');
		$eventDate = Timestamp::parse($request->get('eventDate'));
		
		$registrationEnd = $request->get('registrationEnd').' '.$request->get('registrationEndTime');
		$registrationEnd = Timestamp::parse($registrationEnd);
		
		return new Event($id, $name, $eventDate, $registrationEnd, $international);
	}
	
}
