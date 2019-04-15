<?php 
namespace View;

class ExceptionHandlerView 
{

	public function handleErrorRendering (\Exception $e) {
		switch ($e->getCode()) {
			case 10:
				return "Username is missing";
				break;
			case 11:
				return "Password is missing";
				break;
			case 12:
				return "Username has too few characters, at least 3 characters.";
				break;
			case 13:
				return "Username contains invalid characters.";
				break;

			case 14:
				return "Password has too few characters, at least 6 characters.";
				break;
			case 21:
				return "Wrong name or password";
				break;
			case 22:
				return "Wrong name or password" ;
				break;
			case 31:
				return "Wrong information in cookies" ;
				break;
			case 41:
				return "User exists, pick another username." ;
				break;
			case 42:
				return "Passwords do not match." ;
				break;
			case 51:
				return "Event Day Is Missing" ;
				break;
			case 52:
				return "Event month is missing." ;
				break;
			case 53:
				return "Event Day Is Missing." ;
				break;
			case 54:
				return "Event Place is missing." ;
				break;
			case 55:
				return "Event description is missing." ;
				break;
			default:
				# code...
				break;
		}
	}
}