<?php
namespace View\Calender;

class AddEventView
{
	private static $eventName = "Event::Name";
	private static $eventPlace = "Event::Place";
	private static $eventDescription = "Event::Description";
	private static $monthinput = "Event::Month";
	private static $dayinput = "Event::Day";
	private static $addevent = "Event::Add";
	private $_day;
	private $_month;
	
	function response()
	{
		return $this->createForm();
	}

    private function createForm () : string {
    	return '
    	<div class="registerevent">	
    		    		<a href="?calendar" class="closeevent">X</a>
    	<form action="/?calendar" method="post">
	    	<fieldset>

	    		<legend>Register a new Event</legend>
  					<input type="hidden" name="'.Self::$dayinput.'" value="'.$this->_day.'">
  					<input type="hidden" name="'.Self::$monthinput.'" value="'.$this->_month.'">
					<label for="'.Self::$eventName.'">Event Name</label>
					<br />
					<input type="text" id='.Self::$eventName.' name='.Self::$eventName.'>
					<br />
					<label for="'.Self::$eventPlace.'">Event Place</label>
					<br />
					<input type="text" id='.Self::$eventPlace.' name='.Self::$eventPlace.'>
					<br />
					<label for="'.Self::$eventDescription.'">Event Description</label>
					<br />
					<textarea rows="4" cols="50" id='.Self::$eventDescription.' name='.Self::$eventDescription.'> </textarea>
					<br />
					<input type="submit" name="'.Self::$addevent.'" value="addevent" />
			</fieldset>	
		</form>
		</div>';
    }


    public function setDate(int $month, int $day) : void {
    	$this->_month = $month;
    	$this->_day = $day;
    }

    public function isEventRegistered() : bool {
    	return isset($_POST[Self::$addevent]);
    }

    public function getEventDay() : string {
    	return $_POST[Self::$dayinput];
    }

    public function getEventMont() : string {
    	return $_POST[Self::$monthinput];
    }

    public function getEventName() : string {
    	return $_POST[Self::$eventName];
    }
    public function getEventPlace() : string {
    	return $_POST[Self::$eventPlace];
    }
    public function getEventDescription() : string {
    	return $_POST[Self::$eventDescription];
    }


    public function getEvent() : \Model\Calendar\Event {
    	return new \Model\Calendar\Event($this->getEventDay(), $this->getEventMont(), 
    		$this->getEventName(), $this->getEventPlace(), $this->getEventDescription());
    }


}