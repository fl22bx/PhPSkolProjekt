<?php
namespace Model\LogInModel;


class LogInPercistency
{

	private static $userName = "Session::User";
	private static $password = "Session::Password";
	private static $thisSession = "HTTP_USER_AGENT";
	private $_sqlDatabase;
	private $SQLTableForUsers = 'User';
	
	function __construct(\DatabaseMySQL $SqlDatabase)
	{
		$this->_sqlDatabase = $SqlDatabase;
	}

		public function setNewUser (User $user) {
			$this->_sqlDatabase->connect();
			$dbConnection = $this->_sqlDatabase->getConnection();
			$username = $user->GetName();
			$password = $user->GetPassword();
			$this->isUserDuplicate($username);

			$sql = "INSERT INTO User (name, password)
					VALUES('$username', '$password')
			";
			$conn = $this->_sqlDatabase->getConnection();
			$conn->query($sql);
			$this->_sqlDatabase->stopDb();
	}

	private function isUserDuplicate(string $username) : void{

		$sql = " SELECT * from User
				WHERE name = '$username';
					";
		$result = mysqli_query($this->_sqlDatabase->getConnection(), $sql);
		$tmp = mysqli_fetch_assoc($result);

		if(isset($tmp["name"]))
			throw new \Exception("user_duplication", 41);
			

	}


		public function isAuthenticated (User $user) : bool {
			if($this->isSessionManipulated())
				return false;

			$this->_sqlDatabase->connect();
			$userFromDatabase = $this->queryDatabaseForUser($user->GetName());
			$isAuthenticated = $this->authenticateUser($user->GetPassword(), $userFromDatabase['password']);
			$this->_sqlDatabase->stopDb();
			return $isAuthenticated;
		}

		private function authenticateUser (string $Inputpassword, string $Dbpassword) : bool {
		$bool = password_verify($Dbpassword, $Inputpassword);
		return $bool;

		#	 return ($Inputpassword == $Dbpassword) ? true : false;

		}

		private function isSessionManipulated () : bool {
			if(isset($_SESSION[self::$thisSession]))
				return $_SESSION[self::$thisSession] != $_SERVER[self::$thisSession];
			else 
				return false;

		}

		private function queryDatabaseForUser (string $username) {
				$sql = " SELECT * from $this->SQLTableForUsers 
				WHERE name = '$username';
				";

				$result = mysqli_query($this->_sqlDatabase->getConnection(), $sql);
				$ResultInAssArray = mysqli_fetch_assoc($result);
				if (!isset($ResultInAssArray))
					throw new \Exception("user_dont_exist", 22);

				return $ResultInAssArray;

		}

		public function setSession(User $user) : void {
			$_SESSION[self::$userName] = $user->GetName();
			$_SESSION[self::$password] = $user->GetPassword();
			$_SESSION[self::$thisSession] = $_SERVER[self::$thisSession];

		}

		public function endSession() : void {
			unset($_SESSION[self::$userName]);
			unset($_SESSION[self::$password]);	
			 
		}

		public function isSessionActive () : bool {
			$bool = isset($_SESSION[self::$userName]);
			return $bool;
		}

		public function getSessionUser() : User {				
			$user = new User($_SESSION[self::$userName], $_SESSION[self::$password]);
			return $user;
		}



}