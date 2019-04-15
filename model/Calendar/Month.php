<?php
namespace Model\Calendar;

class Month
{
	private $_days = [];
	private $_monthIndex;
	private $_firstDayOfMonth;
	
	function __construct(int $month)
	{
		date_default_timezone_set('UTC');
		$julianDay = gregoriantojd($month,1,date('Y'));
		$this->_firstDayOfMonth = jddayofweek($julianDay,0);

		$this->_monthIndex = $month;
		$numberOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
		$this->setDays($numberOfDaysInMonth);
	}

	private function setDays (int $numberOfDays) {
		for($i = 1; $i <= $numberOfDays; $i++) {
			$day = new Day($i);
			array_push($this->_days, $day);
		}
	}

	public function getFirstDay() : int {
		return $this->_firstDayOfMonth;
	}

	public function getDays() : array {
		return $this->_days;
	}
}