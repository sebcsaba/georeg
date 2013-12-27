<?php

class EventLoadDaoServiceImpl extends DaoServiceBase implements EventLoadDaoService {
	
	/**
	 * Lists the events.
	 * If the parameter is true, lists only event with open registration.
	 * 
	 * @param boolean $onlyOpenRegistration
	 * @return array(Event)
	 */
	public function listEvents($onlyOpenRegistration) {
		$stmt = $this->createEventQuery($onlyOpenRegistration);
		$result = array();
		foreach ($this->db->query($stmt) as $row) {
			$result []= $this->createEventDao($row);
		}
		return $result;
	}
	
	/**
	 * Loads the event by the given id.
	 * If no event exists with the given id, throws an exception.
	 * 
	 * @param integer $eventId
	 * @return Event
	 * @throws DaoException
	 */
	public function load($eventId) {
		$stmt = $this->createEventQuery(false)->where('id=?', $eventId);
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
	 * @param boolean $onlyOpenRegistration
	 * @return QueryBuilder
	 */
	private function createEventQuery($onlyOpenRegistration) {
		$stmt = QueryBuilder::create()
			->from('event')
			->orderByDesc('event_date');
		if ($onlyOpenRegistration) {
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
