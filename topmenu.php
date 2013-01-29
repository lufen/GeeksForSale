<topMenu>
	<a href="login.php">Log in</a><br>
	<a href="mypage.php">My Page</a><br>
	<a href="register.php">Register</a><br>
	<a href="shoppingbasket.php">Shopping Basket</a><br>
	<?php
	require_once 'sessionStart.php';
	if(isset($_SESSION['id'])){
		echo "<a href=\"index.php?logout=1\">Log Out</a><br>";
	}?>
</topMenu>