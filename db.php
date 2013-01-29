<?php
// Make a php data object
try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=geeksforsale', 'gfs', '');
} catch (PDOException $e) {
    die ('Could not connect to server : ' . $e->getMessage());
}

function convertPlainTextToEncrypted($password,$uid){
	// Convert a password from plaintext into a encrypted one
	$salt = "c63b03f38470b6c30abdb8d2b7e59b14ddeb6a0d6e56956b0df44a0a8dd3cf6980dcbd907cb9aa1ea9edccb37739e20e240ddeafd68d386d289cd68ee9343167";
	$hash = sha1($salt.$uid.$password);
	return $hash;
}
?>
