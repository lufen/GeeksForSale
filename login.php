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
			require 'sessionStart.php';
			require 'user.php';

			if(isset($_SESSION['id'])){
				header( 'Location: mypage.php' );
			}

			if(isset($_POST['email'])){
				if(login($_POST['email'],$_POST['password']) == NULL){
					echo "Wrong username or password";
				}
			}
			//header( 'Location: mypage.php' );
			?>
			<form method="post" action="login.php">
				<h2> Login <small>Enter your credentials</small></h2>
				<p>
					<label for="name">Username:</label>
					<input type="text" name="email" required/>
				</p>
				<p>
					<label for="pwd">Password:</label>
					<input type="password" name="password" required/>
				</p>
				<p>
					<input type="submit" id="submit" value="Login" name="submit"/>
				</p>
			</form>


      </div>
   </BODY>
</HTML>