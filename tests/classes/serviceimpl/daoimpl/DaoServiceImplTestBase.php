<?php

abstract class DaoServiceImplTestBase extends PHPUnit_Framework_TestCase {
	
	/**
	 * db data for an event with id=1, the event date is before the current date
	 * @var array
	 */
	protected $geo1;
	
	/**
	 * db data for an event with id=2, the event date is after the current date, the registration period is over
	 * @var array
	 */
	protected $geo2;
	
	/**
	 * db data for an event with id=3, the registration period is open
	 * @var array
	 */
	protected $geo3;
	
	public function setUp() {
		$this->geo1 = array('id'=>1, 'name'=>'geo1', 'event_date'=>'2013-12-02', 'registration_end'=>'2013-12-01', 'international'=>0);
		$this->geo2 = array('id'=>2, 'name'=>'geo2', 'event_date'=>'2030-12-01', 'registration_end'=>'2013-12-03', 'international'=>0);
		$this->geo3 = array('id'=>3, 'name'=>'geo3', 'event_date'=>'2030-12-31', 'registration_end'=>'2030-12-30', 'international'=>0);
	}
	
	protected function createEventObject(array $src) {
		return new Event(
			I($src, 'id'),
			I($src, 'name'),
			Timestamp::parse(I($src, 'event_date')),
			Timestamp::parse(I($src, 'registration_end')),
			I($src, 'international')
		);
	}
	
}
