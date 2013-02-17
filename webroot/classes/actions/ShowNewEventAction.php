<?php

class ShowNewEventAction implements Action {
	
	public function serve(Request $request) {
		$now = new Timestamp();
		$eventDate = Timestamp::parse($now->addDays(5)->toDayString());
		$registrationDate = Timestamp::parse($now->addDays(7)->toDayString());
		$request->setData('event', new Event(null, '', $eventDate, $registrationDate, false));
		$request->setData('title', 'Új verseny');
		return new PageForward('eventform');
	}
	
}
