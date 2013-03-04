<?php
require 'user.php';
CheckIfWorkerLoggedIn();
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
   echo "Worker page";
   ?>
</div>
</BODY>
</HTML>