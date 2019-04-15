<?php 
	class DatabaseMySQL {
		private $servername;
		private $username;
		private $password;
		private $dbName;
		private $dbConnection;


		 function __construct ($Servername, $Username,$password, $DbName){

			$this->servername = $Servername;
			$this->username = $Username;
			$this->password = $password;
			$this->dbName = $DbName;
		} 

/*
	connects to db

*/
		public function connect () : void {
			$this->dbConnection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

			if($this->dbConnection == false)
			{
			   die(mysqli_connect_error());
			}

		}

		/*
	stops db

	*/
		public function stopDb () {
			$this->dbConnection->close();
		}

//använs nog inte?
		
			public function setNewUser (\Model\Authentication\User $user) : void {
			$db->connect();
			$isDuplicate = $this->isUserDuplicate($this->dbConnection,$username);
			if($isDuplicate)
				throw new \Exception();

			$sql = "INSERT INTO User (name, password)
					VALUES('$username', '$password')
			";

			$dbConnection->query($sql);
			$db->stopDb();

	}


	public function getConnection () {
		return $this->dbConnection;
	}

	}
