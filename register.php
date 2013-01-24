<?php
require_once 'db.php';
if (isset ($_POST['name'])) {
      $sql = 'INSERT INTO users (name, address, email, password, blacklisted, userLevel)VALUES (:name, :address, :email, :password, :blacklisted, :userLevel)';
      $sth = $db->prepare ($sql);
      $adress = $_POST['streetAdress']." ".$_POST['postCode']." ".$_POST['Country'];
      $blacklisted = 0;
      $userLevel = 0;
      $sth->bindValue (':name', $_POST['name']);
      $sth->bindValue (':address', $adress);
      $sth->bindValue (':email', $_POST['Email']);
      $sth->bindValue (':password', $_POST['Password']);
      $sth->bindValue (':blacklisted', $blacklisted);
      $sth->bindValue (':userLevel', $userLevel);
      $sth->execute ();
      if($sth->rowCount() === 1){
         echo "<p>OK<br>";
         header( 'Location: index.php?reg=yes' );
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
            echo "Register";
         ?>

      <form method="post" action="register.php">
      <input type="hidden" name="uid" value="<?php echo $_GET['id']; ?>"/>
      <label for="name">Name</label>
         <input type="text" name="name" required  placeholder="John Doe"/><br/>
      <label for="streetAddress">Street adress</label>
         <input type="text" name="streetAdress" required/><br/>
      <label for="postcode">Post code</label>
         <input type="text" name="postCode" required/><br/>
      <label for="country">Country</label>
         <input type="text" name="Country" required/><br/>
      <label for="Email">Email</label>
         <input type="email" name="Email" required/><br/>
      <label for="Password">Password</label>
         <input type="password" name="Password" required/><br/>
      <input type="submit" value="Register"/>
      </div>
   </BODY>
</HTML>