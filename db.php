<?php
// Make a php data object
try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=geeksforsale', 'gfs', '');
} catch (PDOException $e) {
    die ('Could not connect to server : ' . $e->getMessage());
}

function convertPlainTextToEncrypted($password,$uid){
	// Convert a password from plaintext into a encrypted one
	$salt = "A super secret salt";
	$password =  $password;
	$hash = sha1($salt.$uid.$hash);
	return $hash;
}
?>
