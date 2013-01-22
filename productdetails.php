<?php
   session_start();
   if (isset ($_GET['Quantity'])) {
      $key = "p".trim($_GET['id']);
      if (isset($_SESSION[$key])){
         $_SESSION[$key] = $_SESSION[$key] + $_GET['Quantity'];
      }else{
         $_SESSION[$key] = $_GET['Quantity'];
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
            echo "Details about product <br>";
            $id = $_GET['id'];
            echo "<p>Product ID to show: ".$id;
         ?>
         <form method="get" action="productdetails.php">
         <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
         <label for="Quantity">Quantity</label>
            <input type="number" name="Quantity" required /><br/>
         <input type="submit" value="Put in cart"/>
      </div>
   </BODY>
</HTML>