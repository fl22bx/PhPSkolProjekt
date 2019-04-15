<?php

//INCLUDE THE FILES NEEDED...

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/ExceptionHandlerView.php');
require_once('view/calendar/AddEventView.php');
require_once('view/NavigatorView.php');
require_once('view/calendar/CalendarView.php');
require_once('view/calendar/SpecificEventView.php');

require_once('model/MySqlDataBase.php');
require_once('model/LogInModel/User.php');
require_once('model/LogInModel/LogInPercistency.php');
require_once('model/Calendar/Event.php');
require_once('model/Calendar/EventPercistency.php');
require_once('model/Calendar/Day.php');
require_once('model/Calendar/Calendar.php');
require_once('model/Calendar/CalendarSettings.php');
require_once('model/Calendar/Month.php');

require_once('controller/LogInHandler.php');
require_once('controller/Navigator.php');
require_once('controller/CalenderHandler.php');

require_once('dbCred.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// start session
session_start();

// Create DataBase
// put in seperate file and gitignore
	$bbCred = new dbCred();
	$dbServername = $bbCred->dbServername();
	$dbUsername = $bbCred->dbUsername();
	$dbPassword = $bbCred->dbPassword();
	$dbName = $bbCred->dbName();

	$SqlDatabase = new DatabaseMySQL($dbServername,$dbUsername, $dbPassword, $dbName);

	$SqlLogInDatabase = new Model\LogInModel\LogInPercistency($SqlDatabase);
	$eventPercistency = new \Model\Calendar\EventPercistency($SqlDatabase);
//create Claendar
$cal =  new Model\Calendar\Calendar();
$calSett = new Model\Calendar\CalendarSettings();


//CREATE OBJECTS OF THE VIEWS
$v = new View\LogInView\LoginView();
$navigatorView = new View\NavigatorView();
$dtv = new View\DateTimeView();
$lv = new View\LayoutView($dtv, $navigatorView);
$ehv = new View\ExceptionHandlerView();
$rv = new View\Calender\RegisterView();
$calendarView = new View\Calender\CalendarView($cal,$calSett);

$addEvent = new View\Calender\AddEventView();



//CREATE CONTROLLER
$c = new \Controller\LogInHandler($v, $lv, $SqlLogInDatabase, $ehv, $rv);
$calenderHandler = new Controller\CalenderHandler($calendarView, $addEvent, $ehv, $eventPercistency);
$navigator = new Controller\Navigator($lv, $c, $calenderHandler, $navigatorView);
//$c->startLogInHandler();
$navigator->Navigate();

// $lv->render(false, $v, $dtv);



