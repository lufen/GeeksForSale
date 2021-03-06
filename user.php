<?php
function login ($email,$password) {
	require "db.php";
	$sql = 'SELECT * FROM users WHERE email=:email';
	$sth = $db->prepare ($sql);
	$sth->bindParam (':email', $email);
	$sth->execute ();
	if ($row = $sth->fetch()) {
		$fromUser = convertPlainTextToEncrypted($password,$row['id']);
		if($row['password'] == convertPlainTextToEncrypted($password,$row['id'])){
			$_SESSION['id'] = $row['id'];
			$_SESSION['userLevel'] = $row['userLevel'];
			header( 'Location: mypage.php' );
		} else{
			throw new Exception(' Not logged in,wrong username/password');
		}
	}
}

function changePassword($old,$new){
	require 'db.php';
	// calculate hashes of passwords
	$oldhash = convertPlainTextToEncrypted($old,$_SESSION['id']);
	$newhash = convertPlainTextToEncrypted($new,$_SESSION['id']);

	$db->beginTransaction();
	$db->query('LOCK TABLES users WRITE');
	$sql = 'SELECT * FROM users WHERE id=:id';
	$sth = $db->prepare ($sql);
	$sth->bindParam (':id', $_SESSION['id']);
	$sth->execute ();
	if ($row = $sth->fetch()) {
		if($row['password'] == $oldhash){
			$sql = 'update users set password = :password where id = :id';
			$sth = $db->prepare ($sql);
			$sth->bindValue (':password',$newhash);
			$sth->bindValue (':id',$_SESSION['id']);
			$sth->execute ();
			if ($sth->rowCount()==0) {                      
				$db->rollBack();                      
				$db->query('UNLOCK TABLES');
				throw new Exception('Unable to set new password');  
			}
		}else{
			throw new Exception('Wrong password');
		}
	}
}

function convertPlainTextToEncrypted($password,$uid){
	// Convert a password from plaintext into a encrypted one
	$salt = "c63b03f38470b6c30abdb8d2b7e59b14ddeb6a0d6e56956b0df44a0a8dd3cf6980dcbd907cb9aa1ea9edccb37739e20e240ddeafd68d386d289cd68ee9343167";
	$hash = sha1($salt.$uid.$password);
	return $hash;
}

function registerUser($db,$name, $streetAddress,$postCode,$country, $email, $password, $userLevel=0,$login=1){
	require_once 'sessionStart.php';
	$db->beginTransaction();
	$db->query('LOCK TABLES users WRITE');
	// Add user, then read back and update it with the encrypted one.
	$sql = 'INSERT INTO users (name, streetAddress,postCode,country, email, password, blacklisted, userLevel)VALUES (:name, :streetAddress,:postCode,:country, :email, :password, :blacklisted, :userLevel)';
	$sth = $db->prepare ($sql);
	$sth->bindValue (':name', $name);
	$sth->bindValue (':streetAddress', $streetAddress);
	$sth->bindValue (':postCode', $postCode);
	$sth->bindValue (':country', $country);
	$sth->bindValue (':email', $email);
	$sth->bindValue (':password',"hei");
	$sth->bindValue (':blacklisted', 0);
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
	$sth->bindValue (':password',convertPlainTextToEncrypted($password,$uid));
	$sth->bindValue (':id',$uid);
	$sth->execute ();
	if ($sth->rowCount()==0) {                      
		$db->rollBack();                      
		$db->query('UNLOCK TABLES');
		throw new Exception('Unable to set new password');  
	}
	$db->commit();
	// new user created, then log him in
	if($login===1){
		$_SESSION['id'] = $uid;
		$_SESSION['userLevel'] =  $userLevel;
	}
}

function isUserBlacklisted(){
	require "db.php";
	$sql = 'SELECT * FROM users WHERE id=:id';
	$sth = $db->prepare ($sql);
	$sth->bindParam (':id', $_SESSION['id']);
	$sth->execute ();
	if ($row = $sth->fetch()) {
		if($row['blacklisted'] == 0)
			return false;
		else
			return true;
	}else
	return true;
}

// Check if user,worker or admin logged in, if not then redirect to login page.
function CheckIfUserLoggedIn(){
	require_once 'sessionStart.php';
	if(!isset($_SESSION['id'])){
		header( 'Location: index.php' );
	}
}

// Return true if user logged in
function isUserLoggedIn(){
	require_once 'sessionStart.php';
	if(!isset($_SESSION['id'])){
		return false;
	}
	return true;
}

// Check that an admin is logged in
function CheckIfAdminLoggedIn(){
	require_once 'sessionStart.php';
	if($_SESSION['userLevel'] != 2){
		header( 'Location: index.php' );
	}
}

// Check that a worker is logged in
function CheckIfWorkerLoggedIn(){
	require_once 'sessionStart.php';
	if($_SESSION['userLevel'] != 1){
		header( 'Location: index.php' );
	}
}

function emptyBasket(){
	require_once 'sessionStart.php';
	// Empty out the shoppingbasket
	foreach ($_SESSION as $key => $quantity){
		if($key ==="id" || $key === "userLevel")
			continue;
		unset($_SESSION[$key]);
	}
}
?>