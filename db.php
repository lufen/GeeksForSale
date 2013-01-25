<?php
// Make a php data object
try {
	$db = new PDO('mysql:host=127.0.0.1;dbname=geeksforsale', 'gfs', '');
} catch (PDOException $e) {
    die ('Could not connect to server : ' . $e->getMessage());
}

?>
