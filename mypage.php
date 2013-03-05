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
</div>

<div id="menu">
 <?php
 require_once 'menu.php';
 ?>
</div>

<div id="content">
  <button> <a href="mypage-changeinfo.php"> Update your contact info </a> </button></br>
  <button> <a href="mypage-orders.php?shipped=1"> My shipped orders </a> </button></br>
  <button> <a href="mypage-orders.php?shipped=0"> Orders not shipped yet </a> </button></br>
</div>
</BODY>
</HTML>