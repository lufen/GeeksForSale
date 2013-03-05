<?php
require_once 'sessionStart.php';
if(isset($_GET['logout'])){
  session_unset();
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
 </div>
 
 <div id="menu">
   <?php
   require_once 'menu.php';
   ?>
</div>
<div id="content">
</div>


</BODY>
</HTML>
