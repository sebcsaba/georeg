<?php

class EventAdminServiceImpl extends DbServiceBase implements EventAdminService {
	
	/**
	 * Creates a new event.
	 * If the current has no right to create a new event, throws an exception.
	 * Returns the id of the new event
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @return int
	 * @throws Exception
	 */
	public function createEvent(GeoUser $user, Event $event) {
		if (!$user->isAdmin()) {
			throw new DataAccessException('only admin can create event');
		}
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
	 * If the current user has no right to update the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @throws Exception
	 */
	public function updateEvent(GeoUser $user, Event $event) {
		if (!$user->isAdmin()) {
			throw new DataAccessException('only admin can update event');
		}
		$eventOriginalDate = Timestamp::parse($this->db->queryCell(QueryBuilder::create()
			->from('event')
			->where('id=?', $event->getId())
			->select('event_date')));
		if ($eventOriginalDate->isBefore(new Timestamp())) {
			throw new DataAccessException('cannot update a closed event');
		}
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
	 * If the current user has no right to remove the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param Event $event
	 * @throws Exception
	 */
	public function removeEvent(GeoUser $user, Event $event) {
		if (!$user->isAdmin()) {
			throw new DataAccessException('only admin can remove event');
		}
		$stmt = DeleteBuilder::create()
			->from('event')
			->where('id=?', $event->getId());
		$this->db->exec($stmt);
	}
	
}
