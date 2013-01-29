<?php
	function login ($email,$password) {
			require_once "db.php";
			// $this->email = $_POST['email'];
			 $sql = 'SELECT * FROM users WHERE email=:email';
			 $sth = $db->prepare ($sql);
			 $sth->bindParam (':email', $email);
			 $sth->execute ();
			 if ($row = $sth->fetch()) {
			 	$fromUser = convertPlainTextToEncrypted($password,$row['id']);
				 echo $row['password'];
				 echo $fromUser;
			 	if($row['password'] == convertPlainTextToEncrypted($password,$row['id'])){
				 	$_SESSION['id'] = $row['id'];
				 	//$this->id = $row['id'];
					header( 'Location: mypage.php' );
			 	} else
					echo "Hei";
					 //$this->error = 'Ukjent brukernavn/passord';
					//throw exception
			 }
	}
class User {
	var $email = '';
	var $id = -1;
	var $error = '';
	
	
	//If a user would like to log on, password and username should be checked
	//If the username/password is wrong an error has occured. 
	
	//If a user logs out, the id should be unset
	

	
	function loggedOn () {
		// if ($this->id > -1)
			// return true;
		// else
			// return false;
			

	}

	function getName () {
		if ($this->loggedOn())
			return $this->email;
		else
			return null;
	}
	
	function getID () {
		if ($this->loggedOn())
			return $this->id;
		else
			return null;
	}
	
	function getLoginForm () {
		if ($this->loggedOn())
			return "<form method='post' action='{$_SERVER['REQUEST_URI']}'>\n
			<input type='hidden' name='logout' value='true'/>\n
			<input type='submit' value='Logg av'/>\n</form>";
		else
			return "<form method='post' action='{$_SERVER['REQUEST_URI']}'>$this->error\n
			<label for='uname'>Brukernavn</label><input type='text' name='email'><br/>\n
			<label for='password'>Passord</label><input type='password' name='password'><br/>\n
			<input type='submit' value='Logg på'/>\n</form>";
	}
}
