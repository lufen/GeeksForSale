<<<<<<< HEAD
<?php
require_once 'db.php';

if(isset($_SESSION['id'])){
	header( 'Location: mypage.php' );
}
if (isset ($_POST['name'])) {
      // Add user with a default password, then read back and update it with the encrypted one.
      $sql = 'INSERT INTO users (name, address, email, password, blacklisted, userLevel)VALUES (:name, :address, :email, :password, :blacklisted, :userLevel)';
      $sth = $db->prepare ($sql);
      $adress = $_POST['streetAdress']." ".$_POST['postCode']." ".$_POST['Country'];
      $blacklisted = 0;
      $userLevel = 0;
      $sth->bindValue (':name', $_POST['name']);
      $sth->bindValue (':address', $adress);
      $sth->bindValue (':email', $_POST['Email']);
      $sth->bindValue (':password',"hei");
      $sth->bindValue (':blacklisted', $blacklisted);
      $sth->bindValue (':userLevel', $userLevel);
      $sth->execute ();
      if($sth->rowCount() === 1){
         $uid = $db->lastInsertId();
         echo "<p>OK<br>";
         // Update users password to an encrypted one
         $sql = 'update users set password = :password where id = :id';
         $sth = $db->prepare ($sql);
         $sth->bindValue (':password',convertPlainTextToEncrypted($_POST['Password'],$uid));
         $sth->bindValue (':id',$uid);
         $sth->execute ();
         // Redirect back to homepage
         header( 'Location: index.php?reg=yes' );
      }else{
         echo "User not made, Email not unique";
      }
   }
?>

=======
>>>>>>> 9bf2e278916d3259c00bd3b61309e430f490f17c
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
            require_once 'user.php';
            require_once 'db.php';  
            if (isset ($_POST['name'])) {
            try{
               registerUser($db,$_POST['name'], $_POST['streetAdress'],$_POST['postCode'],$_POST['Country'], $_POST['Email'], $_POST['Password']);
               // Redirect back to homepage
               header( 'Location: mypage.php' );
            }catch(Exception $e){
               echo $e->getMessage();
            }
            }
         ?>
         <form method="post" action="register.php">
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