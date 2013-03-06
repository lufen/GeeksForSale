<?php
require_once "db.php";
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';
if(isset($_POST['name']))
{
	var_dump($_POST);
	$sql = 'UPDATE products set name = :name, price = :price, info = :information, rabatt = :rabatt, categoriID = :subcategory, onStock = :onStock where  id = :id';
	$sth = $db->prepare($sql);
	$sth->bindValue(':name', $_POST['name']);
	$sth->bindValue(':price', $_POST['price']);
	$sth->bindValue(':information', $_POST['information']);
	$sth->bindValue(':rabatt', $_POST['rabatt']);
	$sth->bindValue(':subcategory', $_POST['subcategory']);
	$sth->bindValue(':onStock', $_POST['onStock']);
	$sth->bindValue(':id', $_GET['id']);
	$affectedRows = $sth->execute();
	$line = __LINE__;
	if($affectedRows == 1)
	{
		header( 'Location: admin-Products.php' );
	}
	else
	{
		header('index.php');
	}
}	

?>
<div id= "content">
	<?php
		include 'admin-buttons.php';
		$sql = 'SELECT * FROM products where id = :id';

		$sth = $db->prepare($sql);
		$sth->bindValue(':id', $_GET['id']);
		$affectedRows = $sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$id = $_GET['id'];
		$line = __LINE__;
		$row = $sth->fetch();
		if($affectedRows == 1)
		{
			?>
			<form action="admin-changeProduct.php?id=<?php echo $id;?>" method="post"
    		enctype="multipart/form-data">
				<label for="name">Name of product</label>
				<input type="text" name="name" required="required" value="<?php echo $row['name'];?>"/><br/>
				<label for="price">Price $</label>
				<input type="number" name="price" required="required" value="<?php echo $row['price'];?>"/><br/></br>
				<label for="information">Description</label>
				<input type="text" name="information" required="required" value="<?php echo $row['info'];?>"/><br/></br>
				<label for="rabatt">Discount in percentage</label>
				<input type="number" name="rabatt" required="required" value="<?php echo $row['rabatt'];?>"/><br/>
				<label for="onStock">In storage</label>
				<input type="number" name="onStock" required="required" value="<?php echo $row['onStock'];?>"/><br/>
				<label for="subcategory">Subcategory</label>
	    	<select name="subcategory" required="required">
		      <?php
		      $subcategory = $row['categoriID'];
		      $sql = 'select * from subcategory';
		      $sth = $db->prepare($sql);
		      $sth->execute();
		      $sth->setFetchMode(PDO::FETCH_ASSOC);  
		      while($row = $sth->fetch()){
		      	$selected = "";
		      	if($row['id'] == $subcategory)
		      		$selected = ' selected="selected" ';
		        echo "<option".$selected.' value="'.$row['id'].'">'.$row['name']."</option>";
		      }
		      ?>
    		</select><br>
				<input type="submit" value="Submit changes"/></br>
			</form>		
			<?php
		}
	else
	{
		echo "Affected rows is ",$affectedRows," not 1 on line ", $line+1;
	}
	?>
</div>
