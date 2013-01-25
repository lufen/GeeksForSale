<?php
class User {
	var $email = '';
	var $id = -1;
	var $error = '';
	
	
	//If a user would like to log on, password and username should be checked
	//If the username/password is wrong an error has occured. 
	
	//If a user logs out, the id should be unset
	
	
	function User ($db) {
		global $_POST, $_SESSION;
		if (isset ($_POST['email'])) {
			$password = md5($_POST['password']);
			$this->email = $_POST['email'];
			$sql = 'SELECT * FROM users WHERE email=:email AND password=:password';
			$sth = $db->prepare ($sql);
			$sth->bindParam (':email', $this->email);
			$sth->bindParam (':password', $password);
			$sth->execute ();
			if ($row = $sth->fetch()) {
				$_SESSION['id'] = $row['id'];
				$this->id = $row['id'];
			} else
				$this->error = 'Ukjent brukernavn/passord';
		} else if (isset ($_POST['logout'])) {
			unset ($_SESSION['id']);
		} else if (isset ($_SESSION['id'])) {
			$this->id = $_SESSION['id'];
			$sql = 'SELECT * FROM users WHERE id=:id';
			$sth = $db->prepare ($sql);
			$sth->bindParam (':id', $_SESSION['id']);
			$sth->execute ();
			$row = $sth->fetch();
			$this->email = $row['email'];
		}
	}
	
	function loggedOn () {
		if ($this->id > -1)
			return true;
		else
			return false;
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
