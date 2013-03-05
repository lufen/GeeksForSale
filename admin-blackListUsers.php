<?php
include 'Geeksforsaletop.php';
?>

<?php
require_once "user.php";
CheckIfAdminLoggedIn();

function toggleBlocklist(){
	require 'db.php';
	try{
		$db->beginTransaction();
		$db->query('LOCK TABLES users WRITE');
		// Add user, then read back and update it with the encrypted one.
		$sql = 'UPDATE users set blacklisted=:blacklisted where id=:id';
		$sth = $db->prepare ($sql);
		// Was the user before blacklisted
		if(intval($_POST['old'])==0)
			$sth->bindValue (':blacklisted', 1);
		else
			$sth->bindValue (':blacklisted', 0);

		$sth->bindValue (':id', $_POST['userID']);
		$affected_rows = $sth->execute();
		if($affected_rows != 1){
			// Should only change for one user at the time
			$db->rollBack();                      
			$db->query('UNLOCK TABLES');
			throw new Exception('Unable to update information');  
		}
	}catch (Exception $e){
		$db->rollBack();                      
		$db->query('UNLOCK TABLES');
		throw new Exception('Unable to update information, Email duplicate');  
	}
	$db->commit();
	echo "<p>User blacklisted";
}

function findUser(){
	require 'db.php';
	if (isset ($_POST['search'])) {
		try{
			$sql = 'select * from users where email=:search OR id=:search OR name=:search';
			$sth = $db->prepare($sql);
			$sth->bindValue(':search', $_POST['search']);
			$sth->execute();
			$sth->setFetchMode(PDO::FETCH_ASSOC);  
			while($row = $sth->fetch()){
				echo "<div id=user>";
				echo "<t2>Name: ".$row['name']."</t2></br>";
				if(intval($row['blacklisted'])==0)
					echo "NOT blacklisted</br>";
				else
					echo "Blacklisted!!</br>";
				echo "<t2>".$row['email']."</t2></br>";
				echo "<t3>Address: ".$row['streetAddress']."</t3></br>";
				echo "<t3>".$row['postCode']."</t3></br>";
				echo "<t3>".$row['country']."</t3></br>";

				echo'<form method="post" action="admin-blackListUsers.php">';
				echo "<input type=\"hidden\" name=\"userID\" value=".$row['id']."/>";
				echo "<input type=\"hidden\" name=\"old\" value=".$row['blacklisted']."/>";
				echo '<input type="submit" value="Blacklist/Unblacklist"/>';
				echo "</div>";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
}
?>

<?php
include 'Geeksforsaletop.php';
?>
<div id="content">
	<form class="form-wrapper cf" method="post" action="admin-blackListUsers.php">
		<input type="text" name="search" placeholder="Search here after email or ID" required>
		<button type="submit">Search</button>
	</form>
	<?php
	require 'db.php';
	if (isset ($_POST['id'])) {
		try{
			toggleBlocklist();
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	if (isset ($_POST['search'])) {
		try {
			findUser();
		}catch (Exception $e){
			echo $e->getMessage();
			echo "Something went wrong. Codemonkeys on it";
		}
	}
	
	?>
</div>
</BODY>
</HTML>