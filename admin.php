<?php
  require_once 'db.php';
  // Add a new top category
  if(isset($_POST['categoryName'])){
    $sql = 'INSERT into productcategory (categoryName) values (:categoryName)';
    $sth = $db->prepare($sql);
    $sth->bindValue (':categoryName', $_POST['categoryName']);
    if($sth->execute() === 1){
         echo "<p>OK<br>";
         header( 'Location: admin.php' );
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
   	   	<h1>
               <?php
   			      echo "Geeks for sale!!!";
   		       ?>
            </h1>
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
            echo "Admin";
         ?>
         <p> Add a new top category
        <form action="admin.php" method="post">
        <input type="text" name="categoryName" required />
        <input type="submit" name="submit" value="Add">
        </form>
      </div>
   </BODY>
</HTML>