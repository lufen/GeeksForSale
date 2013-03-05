<topMenu>
       <form class="form-wrapper cf" method="post" action="search.php">
          <input type="text" name="search" placeholder="Search here..." required>
          <button type="submit">Search</button>
       </form>
	<?php
	require_once 'sessionStart.php';
	if(isset($_SESSION['id'])){
		echo "<a href=\"index.php?logout=1\">Log Out</a><br>";
		echo "<a href=\"mypage.php\">My Page</a><br>";
		echo "<a href=\"changePassword.php\">Change password</a><br>";
		if($_SESSION['userLevel'] == 1){
			echo "<a href=\"worker.php\">My Worker Page</a><br>";
		}else if($_SESSION['userLevel'] == 2){
			echo "<a href=\"admin.php\">My Admin Page</a><br>";
		}
	}else{
		echo "<a href=\"login.php\">Log in</a><br>";
		echo "<a href=\"register.php\">Register</a><br>";
	}
	?>
	<a href="shoppingbasket.php">Shopping Basket</a><br>
</topMenu>