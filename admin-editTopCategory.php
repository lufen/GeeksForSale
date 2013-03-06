<?php
require_once "user.php";
CheckIfAdminLoggedIn();

function changeCategory(){
		require 'db.php';
		try{
		$db->beginTransaction();
		$db->query('LOCK TABLES productcategory WRITE');
		// Add user, then read back and update it with the encrypted one.
		$sql = 'UPDATE productcategory set categoryName=:categoryName, visible=:visible where id=:id';
		$sth = $db->prepare ($sql);
		$sth->bindValue (':categoryName', $_POST['name']);
		$sth->bindValue (':visible', $_POST['visible']);
		$sth->bindValue (':id', $_POST['id']);
		$affected_rows = $sth->execute();
		echo $affected_rows;
		if($affected_rows != 1){
			// Should only change for one user at the time
			$db->rollBack();                      
			$db->query('UNLOCK TABLES');
			throw new Exception('Unable to update information');  
		}
		}catch (Exception $e){
			$db->rollBack();                      
			$db->query('UNLOCK TABLES');
			throw new Exception('Unable to update information');  
		}
		$db->commit();
		echo "<p>Update done";
}
?>

<?php
include 'Geeksforsaletop.php';
?>

<div id="content">
	<?php 
	include 'admin-buttons.php'; 
	?>
	<t1> Edit a category</t1></br>

	<?php
	if(isset($_POST['name'])){
		try{
			changeCategory();
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	if(isset($_POST['category'])){
	// Get ID of top category
		$sql = 'select * from productcategory where id = :id';
		$sth = $db->prepare($sql);
		$sth->bindValue (':id', $_POST['category']);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);
	// only add if we only found one category
		if($sth->rowCount() === 1){
			$row = $sth->fetch();
		}
	}
	?>
	<form method="post" action="admin-editTopCategory.php">
		<input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
		<label for="name">Name</label>
		<input type="text" name="name" required value ="<?php echo $row['categoryName'];?>"/></br>
		<label for="visible">Visible?</label>
		<select id="visible" name="visible" required>
			<option value="1">Visible</option>
			<option value="0">Not visible</option>
		</select></br></br>
		<input type="submit" value="Update"/>
	</div>
</BODY>
