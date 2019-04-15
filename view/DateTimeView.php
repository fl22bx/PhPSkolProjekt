<?php
namespace View;

class DateTimeView {

/*
	Render date and time

*/

	public function show() {
		date_default_timezone_set('America/Los_Angeles');
		$date = date('l\,');
		$date .= ' the ';
		$date  .= date('jS \of F Y\,');
		$date .= ' The time is ';
		$date .= date('H\:i');

		return "<p> $date</p>";
	}
}