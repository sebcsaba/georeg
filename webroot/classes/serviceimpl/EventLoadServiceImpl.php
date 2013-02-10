<?php

class EventLoadServiceImpl extends DbServiceBase implements EventLoadService {
	
	/**
	 * Lists the events visible for the given user.
	 * For an admin user, it shows all the events.
	 * For a non-admin user, it shows all the open events.
	 * 
	 * @param GeoUser $user
	 * @return array(Event)
	 */
	public function listEvents(GeoUser $user) {
		$stmt = $this->createEventQuery($user);
		$result = array();
		foreach ($this->db->query($stmt) as $row) {
			$result []= $this->createEventDao($row);
		}
		return $result;
	}
	
	/**
	 * Loads the event by the given id.
	 * If the current user cannot see the given event, throws an exception.
	 * 
	 * @param GeoUser $user
	 * @param integer $eventId
	 * @return Event
	 * @throws Exception
	 */
	public function load(GeoUser $user, $eventId) {
		$stmt = $this->createEventQuery($user)->where('id=?', $eventId);
		$row = $this->db->queryRow($stmt, true);
		if (is_null($row)) {
			throw new DataAccessException('the given event is closed now');
		} else {
			return $this->createEventDao($row);
		}
	}
	
	/**
	 * Creates a query returing relevant events
	 * 
	 * @param GeoUser $user
	 * @return QueryBuilder
	 */
	private function createEventQuery(GeoUser $user) {
		$stmt = QueryBuilder::create()
			->from('event')
			->orderByDesc('event_date');
		if (!$user->isAdmin()) {
			$stmt->where('event_date >= CURRENT_DATE()');
		}
		return $stmt;
	}
	
	/**
	 * Creates an Event object from the given database row
	 * 
	 * @param array $eventData
	 * @return Event
	 */
	private function createEventDao(array $eventData) {
		return new Event(
			$eventData['id'],
			$eventData['name'],
			Timestamp::parse($eventData['event_date']),
			Timestamp::parse($eventData['registration_end']),
			$eventData['international']);
	}
	
}
