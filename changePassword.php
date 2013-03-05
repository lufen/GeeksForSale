<?php
require 'user.php';
CheckIfUserLoggedIn();
?>
<?php
include 'Geeksforsaletop.php';
?>

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