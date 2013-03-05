<?php
require 'user.php';
CheckIfUserLoggedIn();
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
  <?php require_once("topmenu.php"); ?>
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
  if(isset($_POST['newPassword1'])){
  if($_POST['newPassword1'] == $_POST['newPassword2'])
    try{
      changePassword($_POST['oldassword'],$_POST['newPassword1']);
    }catch (exception $e){
      echo $e->getMessage();
    }
    echo "<p> Password changed</p>";
  }
    ?>
    <h1> Change password </h1>
     <form method="post" action="changePassword.php">
    <label for="Password">Old Password</label>
    <input type="password" name="oldassword" required/><br/>
    <label for="Password"> New Password</label>
    <input type="password" name="newPassword1" required/><br/>
    <label for="Password">Retype password</label>
    <input type="password" name="newPassword2" required/><br/>
    <input type="submit" value="Update"/>
  </div>
</BODY>
</HTML>