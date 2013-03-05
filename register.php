
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
         registerUser($db,$_POST['name'], $_POST['streetAddress'],$_POST['postCode'],$_POST['Country'], $_POST['Email'], $_POST['Password']);
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
      <input type="text" name="streetAddress" required/><br/>
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