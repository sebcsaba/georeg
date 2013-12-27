<?php

class Event {
	
	/**
	 * Identifier of the event
	 * 
	 * @var integer or null
	 */
	private $id;
	
	/**
	 * Name of the event
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * Date of the event
	 * 
	 * @var Timestamp
	 */
	private $eventDate;
	
	/**
	 * End of the registration for this event
	 * 
	 * @var Timestamp
	 */
	private $registrationEnd;
	
	/**
	 * True, if it's an international event
	 * 
	 * @var boolean
	 */
	private $international;
	
	public function __construct($id, $name, Timestamp $eventDate, Timestamp $registrationEnd, $international) {
		$this->id = $id;
		$this->name = $name;
		$this->eventDate = $eventDate;
		$this->registrationEnd = $registrationEnd;
		$this->international = $international;
	}
	
	/**
	 * Returns the identifier of the event
	 * 
	 * @return integer or null
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Returns the name of the event
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the date of the event
	 * 
	 * @return Timestamp
	 */
	public function getEventDate() {
		return $this->eventDate;
	}
	
	/**
	 * Returns the end of the registration for this event
	 * 
	 * @return Timestamp
	 */
	public function getRegistrationEnd() {
		return $this->registrationEnd;
	}
	
	/**
	 * True, if it's an international event
	 * 
	 * @return boolean
	 */
	public function getInternational() {
		return $this->international;
	}
	
}
