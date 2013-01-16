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
            echo "Product category ";
            $id = $_GET['id'];
            echo $id;

            $sql = "Select id,name,price from varer where categoriID= ".$id;
            $sth = $db->prepare($sql);
            $sth->execute();
            $sth->setFetchMode(PDO::FETCH_ASSOC);  
            $array = array();
            echo "<br>";
            while($row = $sth->fetch()){
               echo "<a href=\"productdetails.php?id=".$row['id']."\">".$row['name']."</a> ";
               echo $row['price']." <br>";
            }
         ?>
      </div>
   </BODY>
</HTML>