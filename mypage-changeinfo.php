<?php
require 'user.php';
CheckIfUserLoggedIn();
function UpdateUserInfo(){
	require 'db.php';  
	if (isset ($_POST['name'])) {
		$db->beginTransaction();
		$db->query('LOCK TABLES users WRITE');
	// Add user, then read back and update it with the encrypted one.
		$sql = 'UPDATE users set name=?, streetAdress=?,postCode=?,country=?, email=? where id=?';
		$sth = $db->prepare ($sql);
		$affected_rows = $sth->execute (array($_POST['name'],$_POST['streetAdress'],$_POST['postCode'],$_POST['Country'],$_POST['Email'],$_SESSION['id']));
		if($affected_rows != 1){
		// Should only change for one user at the time
			$db->rollBack();                      
			$db->query('UNLOCK TABLES');
			throw new Exception('Unable to set new password');  
		}
		$db->commit();
		echo "<p>User information set and updated";
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<HTML>
	<HEAD>
		<TITLE>Geeks For Sale</TITLE>
		<link rel="stylesheet" type="text/css" href="StyleIndex.css"/>
	</HEAD>
	<BODY>
		<div id="header">
			<?php include("topmenu.php"); ?>
			<s>
				<form class="form-wrapper cf">
					<input type="text" placeholder="Search here..." required>
					<button type="submit">Search</button>
				</form>
			</s>
		</div>

		<div id="menu">
			<?php
			require_once 'menu.php';
			?>
		</div>
		<div id="content">
			<?php 
			UpdateUserInfo();
			?>
			<form method="post" action="mypage-changeinfo.php">
				<label for="name">Name</label>
				<?php
				// Get ID of top category
				$sql = 'select * from users where id = :id';
				$sth = $db->prepare($sql);
				$sth->bindValue (':id', $_SESSION['id']);
				$sth->execute();
				$sth->setFetchMode(PDO::FETCH_ASSOC);
				// only add if we only found one category
				if($sth->rowCount() === 1){
					$row = $sth->fetch();
				}
				?>
				<input type="text" name="name" required  value ="<?php echo $row['name'];?>"/><br/>
				<label for="streetAddress">Street adress</label>
				<input type="text" name="streetAdress" required value="<?php echo $row['streetAdress'];?>"/><br/>
				<label for="postcode">Post code</label>
				<input type="text" name="postCode" required value="<?php echo $row['postCode'];?>"/><br/>
				<label for="country">Country</label>
				<input type="text" name="Country" required value="<?php echo $row['country'];?>"/><br/>
				<label for="Email">Email</label>
				<input type="email" name="Email" required value="<?php echo $row['email'];?>"/><br/>
				<input type="submit" value="Update"/>
			</div>
		</BODY>
	</HTML>