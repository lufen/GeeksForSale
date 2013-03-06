<?php
require 'user.php';
CheckIfUserLoggedIn();
function UpdateUserInfo(){
	require 'db.php';  
	if (isset ($_POST['name'])) {
		try{
		$db->beginTransaction();
		$db->query('LOCK TABLES users WRITE');
		// Add user, then read back and update it with the encrypted one.
		$sql = 'UPDATE users set name=:name, streetAddress=:streetAddress,postCode=:postCode,country=:country, email=:email where id=:id';
		$sth = $db->prepare ($sql);
		$sth->bindValue (':name', $_POST['name']);
		$sth->bindValue (':streetAddress', $_POST['streetAddress']);
		$sth->bindValue (':postCode', $_POST['postCode']);
		$sth->bindValue (':country',$_POST['Country']);
		$sth->bindValue (':email', $_POST['Email']);
		$sth->bindValue (':id', $_SESSION['id']);
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
		echo "<p>User information set and updated";
	}
}
?>

<?php
include 'Geeksforsaletop.php';
?>
		<div id="content">
			<?php include 'mypage-buttons.php'; ?>
			<?php 
			try{
				UpdateUserInfo();
			}catch (Exception $e){
				echo $e->getMessage();
			}
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
				<input type="text" name="streetAddress" required value="<?php echo $row['streetAddress'];?>"/><br/>
				<label for="postcode">Post code</label>
				<input type="number" name="postCode" required value="<?php echo $row['postCode'];?>"/><br/>
				<label for="country">Country</label>
				<select id="Country" name="Country" required	>
				<?php include 'countryList.php'; ?>
				<option selected="selected"><?php echo $row['country'] ?></option>
				</select></br>
				<label for="Email">Email</label>
				<input type="email" name="Email" required value="<?php echo $row['email'];?>"/><br/>
				<input type="submit" value="Update"/>
			</div>
		</BODY>
	</HTML>