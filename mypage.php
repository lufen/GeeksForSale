<?php
require 'user.php';
CheckIfUserLoggedIn();
?>

<?php
include 'Geeksforsaletop.php';
?>

<div id="content">
  <button> <a href="mypage-changeinfo.php"> Update your contact info </a> </button></br>
  <button> <a href="mypage-orders.php?shipped=1"> My shipped orders </a> </button></br>
  <button> <a href="mypage-orders.php?shipped=0"> Orders not shipped yet </a> </button></br>
</div>
</BODY>
</HTML>