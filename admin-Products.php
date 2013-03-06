<?php
require_once "db.php";
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';

if(isset($_POST['productid']))
{
	$sql = 'select * from products where id = :id';
	$sth = $db->prepare($sql);
	$sth->bindValue(':id', $_POST['productid']);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$row = $sth->fetch();
	if($row['forSale'] == 1)
	{
		$sql = 'UPDATE products set forSale=0 where id=:id';
	}
	elseif ($row['forSale'] == 0)
	{
		$sql = 'UPDATE products set forSale=1 where id=:id';
	}
	else
	{
		echo "forSale was not 0 or 1 on line ",__LINE__," in admin-Products.";
	}
	
	$sth = $db->prepare($sql);
	$sth->bindValue (':id', $_POST['productid']);
	$affectedRows = $sth->execute();
	if($affectedRows != 1)
	{
		echo "Affected rows not equal to 1 on line ",__LINE__,"in admin-Products.";
	}
}

?>
<div id= "content">
	<?php
		include 'admin-buttons.php';
		$sql = "Select * from productcategory";
		$sth = $db->prepare($sql);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);  
		while($categoryrow = $sth->fetch())
		{
			echo "<br><t1>".$categoryrow['categoryName']."</t1><br>";
				// Get subcategories
			$sql = "Select * from subcategory where categoryid = ".$categoryrow['id'];
			$sth2 = $db->prepare($sql);
			$sth2->execute();
			$sth2->setFetchMode(PDO::FETCH_ASSOC);
			while($subCategoryRow = $sth2->fetch())
			{
				echo "<t2I>".$subCategoryRow['name']."</t2I><br>";
				$subCategoryId = $subCategoryRow['id'];
				$sql = "SELECT * from products where categoriID = ".$subCategoryId;
				$sth3 = $db->prepare($sql);
				$sth3->execute();
				$sth3->setFetchMode(PDO::FETCH_ASSOC);

				while($productrow = $sth3->fetch())
				{
					if($productrow['forSale'] == 1) 
						$forSale = " ";
					else
						$forSale = " not ";
					echo "<t3><a href=\"productdetails.php?id=".$productrow['id']."\">".$productrow['name']."    Product is".$forSale."for sale.</a></t3>     
					<button> <a href=\"admin-changeProduct.php?id=".$productrow['id']."\"> Edit a product        </a> </button>";
				  echo'<form method="post" action="admin-Products.php">';
				  echo "<input type=\"hidden\" name=\"productid\" value=".$productrow['id']."/>";
				  echo '<input type="submit" value="Toggle on sale"/></br>';
				  echo '</form>';

					//<button> <a href=\"admin-Products.php?id=".$productrow['id']."\"> Edit a product        </a> </button> <br>";
				}
			}
		}
	?>
</div>
