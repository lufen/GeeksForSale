<?php
// Make a php data object
try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=geeksforsale', 'gfs', '');
} catch (PDOException $e) {
    die ('Could not connect to server : ' . $e->getMessage());
}

function convertPlainTextToEncrypted($password,$uid){
	// Convert a password from plaintext into a encrypted one
	$salt = "fe31661650ad180d494d45b6ad81f2b924d627ae56675525ace771c8cf65a2e6";
	$password =  $password;
	$hash = sha1($salt.$uid.$hash);
	return $hash;
}
?>
