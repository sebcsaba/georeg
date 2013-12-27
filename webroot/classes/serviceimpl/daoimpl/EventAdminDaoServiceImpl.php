<?php

class EventAdminDaoServiceImpl extends DaoServiceBase implements EventAdminDaoService {
	
	/**
	 * Creates a new event.
	 * Returns the id of the new event
	 * 
	 * @param Event $event
	 * @return int
	 */
	public function createEvent(Event $event) {
		$stmt = InsertBuilder::create()
			->into('event')
			->set('name', $event->getName())
			->set('event_date', $event->getEventDate())
			->set('registration_end', $event->getRegistrationEnd())
			->set('international', $event->getInternational());
		return $this->db->insert($stmt);
	}
	
	/**
	 * Updates the given event.
	 * 
	 * @param Event $event
	 */
	public function updateEvent(Event $event) {
		$stmt = UpdateBuilder::create()
			->update('event')
			->set('name', $event->getName())
			->set('event_date', $event->getEventDate())
			->set('registration_end', $event->getRegistrationEnd())
			->set('international', $event->getInternational())
			->where('id=?', $event->getId());
		$this->db->exec($stmt);
	}
	
	/**
	 * Removes the given event.
	 * 
	 * @param Event $event
	 */
	public function removeEvent(Event $event) {
		$stmt = DeleteBuilder::create()
			->from('event')
			->where('id=?', $event->getId());
		$this->db->exec($stmt);
	}
	
}
