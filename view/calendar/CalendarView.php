<?php
namespace View\Calender;


class CalendarView implements \View\IDivHtml
{

	private static $_eventMonth = "Event::Month";
	private static $_eventDay = "Event::Day";
	private static $_add = "Event::Add";
	private static $_view = "Event::View";
	private static $_swe = "Event::Swe";
	private static $_eng = "Event::Eng";
	private static $_lang = "Event::Language";
	private static $_monthToView = "Event::MonthToView";
	private $_calendar;
	private $_calenderSettings;
	private $_divOverlay;
	private $_message = "";
	private $_user;
	private $_events;


	function __construct(\Model\Calendar\Calendar $calendar, \model\Calendar\CalendarSettings $calSetting)
		 {
		    $this->_calendar = $calendar;
		    $this->_calenderSettings = $calSetting;
		 }


	public function response() : string {	
		if($this->isSweCalSet())
			$this->_calenderSettings->swedishCalendar();
		else
			$this->_calenderSettings->englishCalendar();

		$monthToView = $this->getMonthToView();
		return '
		<div class="calendar">
		'.$this->monthHeader($monthToView).'
		<p>'.$this->_message.'</p>
		'.$this->_divOverlay.'
			<ul class="weekdays">
				' . $this->calenderHeader() . '
	
			</ul>
			<ul class="days">
				' . $this->daysInCalender($monthToView) . '
			</ul>


		</div>
		';
	 }

	 public function renderOverlayDiv(string $divOverlay) {
	 	$this->_divOverlay = $divOverlay;
	 }

	 private function monthHeader(int $monthToView) : string {
	 	$month = $this->_calenderSettings->getNameOfMonths();
	 	$month = $month[$monthToView];
	 	$nextMonth = $monthToView + 1;
	 	$previousMonth = $monthToView - 1;
	 	return '<div class"monthHeader">
	 	<a href="?calendar&'.Self::$_monthToView.'='.$previousMonth.'" class="next"><</a>
		<h1>'.$month.'</h1>
		<a href="?calendar&'.Self::$_monthToView.'='.$nextMonth.'" class="next">></a>
			<form method="post" class="form"> 
				<select name="'.Self::$_lang.'">
  					<option name="'.Self::$_swe.'" value="'.Self::$_swe.'">Swe</option>
  					<option name="'.Self::$_eng.'" value="'.Self::$_eng.'">Eng</option>
				</select>
				<input type="submit" value="ChangeLanguage" />
			</form>
	 	</div>';
	 }

	 public function getMonthToView() : int {
	 	if(isset($_GET[Self::$_monthToView ]))
	 		return $_GET[Self::$_monthToView];
	 	else 
	 		return date('n') - 1;
	 }

	 private function calenderHeader() : string {
	 	$weekdays = $this->_calenderSettings->getNameOfWeekDays();
	 	$header = "";
	 	foreach ($weekdays as $weekday) {
	 		$header .= '	
	 		<li class="dayName li">	
					'.$weekday.'
			</li>';
	 	}
	 	return $header;
	 }

	 private function daysInCalender(int $monthToView) : string {

	 	$Month = $this->_calendar->getMonth($this->getMonthToView());
	 	$firstWeekDay = $Month->getFirstDay();
	 	$days = $Month->getDays();

		$result = "";
		for($i = 1; $i < $firstWeekDay; $i++) {
				$result .= '
				<li class="li day shadowed">	
				</li>
				';
		}

		foreach ($days as $day) {
			$result .=  '
				<li class="li day">	
				<p class="dateNumber">' . $day->getDate() .' </p>
				<div class="add"><a href="?calendar&'.Self::$_add.'&'.Self::$_eventDay.'='.$day->getDate().'&'.Self::$_eventMonth.'='.$monthToView.'&'.Self::$_monthToView.'='.$this->getMonthToView().'">+</a></div>
				
				<p class="event" > '.$this->events($day->getDate(), $monthToView).'</p>

				</li>
				';
		}


	 	return $result;
	 }

	 private function events(int $day, int $month) : string {
	 	$eventsCalc = 0;
	 	foreach ($this->_events as $event) {
	 		if($event->getDay() == $day) {
	 			$eventsCalc++;
	 		}
	 	}

	 	if ($eventsCalc == 0) {
	 		return '<p class="event0">Events(0)</p>';
	 	} else {
	 		return '
	 		<p><a href="?calendar&'.Self::$_view.'&'.Self::$_eventMonth.'='.$month.'&
	 		'.Self::$_eventDay.'='.$day.'&'.Self::$_monthToView.'='.$this->getMonthToView().'" class="eventCalc event'.$eventsCalc.'">Events('.$eventsCalc.')</a></p>
	 		';
	 	}


	 }

	 public function setEvents(array $userEvents) : void {
	 	$this->_events = $userEvents;
	 }

	 public function wantsToViewEvent() : bool {
	 	return isset($_GET[Self::$_view]);
	 }


	public function setMessage (string $message) : void {
		$this->_message = $message;
	}

    public function wantsToRegisterEvent() : bool {
    	return isset($_GET[Self::$_add]);

    }

    public function setUser(\Model\LogInModel\User $user = null) : void {
    	$this->_user = $user;
    }

    public function getEventDay() : string {
    	return $_GET[Self::$_eventDay];
    }

    public function getEventMonth() : string {
    	return $_GET[Self::$_eventMonth];
    }

    private function isSweCalSet() : bool {
		if (isset($_POST[Self::$_lang]) && $_POST[Self::$_lang] == Self::$_swe)
			return true;
		else 
			return false;
	}

}