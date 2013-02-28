<topMenu>
		<?php
	require_once 'sessionStart.php';
	if(isset($_SESSION['id'])){
		echo "<a href=\"index.php?logout=1\">Log Out</a><br>";
	}else{
		echo "<a href=\"login.php\">Log in</a><br>";
		echo "<a href=\"register.php\">Register</a><br>";
	}
	?>
	<a href="mypage.php">My Page</a><br>
	<a href="shoppingbasket.php">Shopping Basket</a><br>

</topMenu>