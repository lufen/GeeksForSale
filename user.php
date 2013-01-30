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

function registerUser($db,$name, $streetAdress,$postCode,$Country, $email, $password){
	require_once 'sessionStart.php';
	$db->beginTransaction();
	$db->query('LOCK TABLES users WRITE');
	// Add user, then read back and update it with the encrypted one.
	$sql = 'INSERT INTO users (name, address, email, password, blacklisted, userLevel)VALUES (:name, :address, :email, :password, :blacklisted, :userLevel)';
	$sth = $db->prepare ($sql);
	$adress = $streetAdress." ".$postCode." ".$Country;
	$blacklisted = 0;
	$userLevel = 0;
	$sth->bindValue (':name', $name);
	$sth->bindValue (':address', $adress);
	$sth->bindValue (':email', $email);
	$sth->bindValue (':password',"hei");
	$sth->bindValue (':blacklisted', $blacklisted);
	$sth->bindValue (':userLevel', $userLevel);
	$sth->execute ();
	if($sth->rowCount() == 0){
	 // In case of error, rollback
	 $db->rollBack();                     
	 $db->query ('UNLOCK TABLES'); 
	 throw new Exception('email not unique');
	}
	$uid = $db->lastInsertId();
	echo "<p>OK<br>";
	// Update users password to an encrypted one
	$sql = 'update users set password = :password where id = :id';
	$sth = $db->prepare ($sql);
	$sth->bindValue (':password',convertPlainTextToEncrypted($_POST['Password'],$uid));
	$sth->bindValue (':id',$uid);
	$sth->execute ();
	if ($sth->rowCount()==0) {                      
	 $db->rollBack();                      
	 $db->query('UNLOCK TABLES');
	 throw new Exception('Unable to set new password');  
	}
	$db->commit();
	// new user created, then log him in
	$_SESSION[$uid];
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
