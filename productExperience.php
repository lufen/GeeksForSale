<?php
include 'Geeksforsaletop.php';
?>
<?php
function AddExperience(){
	try{
		require 'db.php';
		$db->beginTransaction();
		$db->query('LOCK TABLES productexperience WRITE');
		$sql = 'INSERT INTO productexperience (grade, comment,productID)VALUES (:grade,:comment,:productID)';
		$sth = $db->prepare($sql);
		$sth->bindValue (':grade', $_POST['grade']);
		$sth->bindValue (':comment', $_POST['Experience']);
		$sth->bindValue (':productID', $_POST['id']);
		$affectedRows = $sth->execute();
		$db->commit();
		$id = $_POST['id'];
		header("Location: productdetails.php?id=$id");
		if($affectedRows != 1){
			$db->rollBack();                      
			$db->query('UNLOCK TABLES');
			throw new Exception('Unable to add new experience');  
		}
	}catch(Exception $e){
		$db->rollBack();                      
		$db->query('UNLOCK TABLES');
		throw new Exception('Unable to add new experience'); 
	}
}
?>

<div id="content">
	<?php
	if(isset($_POST['pID'])){
		$pID = $_POST['pID'];
	}
	if(isset($_POST['Experience'])){
		try{
			AddExperience();
			echo "<t2>Experience added</t2></br>";
			
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	?>

	<form method="post" action="productExperience.php">
		<input type="hidden" name="id" value="<?php echo $pID; ?>"/>
		<label for="Experience">Experience</label>
		<input type="text" name="Experience" required  placeholder="Your experience" size="100"/><br/>
		<label for="grade">Grade</label>
		<select name="grade">
			<?php
			for ($i = 1; $i <= 10; $i++) {
				echo "<option value=\"".$i."\">".$i."</option>";
			}
			?>
			<input type="submit" value="Click to add experience"/>
		</div>
	</BODY>
</HTML>