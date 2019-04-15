<?php
namespace Model\Calendar;

class CalendarSettings
{
	private $_nameOfMonths;
	private $_nameOfWeekDays;
	private $_redDays;
	
	public function englishCalendar() : void {
		$this->_nameOfMonths = ["January", "Februar", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$this->_nameOfWeekDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
	}

		public function swedishCalendar() : void {
		$this->_nameOfMonths = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];
		$this->_nameOfWeekDays = ["Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag"];
	}

	public function getNameOfMonths() : Array {
		return $this->_nameOfMonths;
	}

	public function getNameOfWeekDays() : Array {
		return $this->_nameOfWeekDays;
	}

}