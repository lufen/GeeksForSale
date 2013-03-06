<?php
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';
?>

<div id= "content">
	<?php include 'admin-buttons.php'; ?>
    <p>Add user<br>
      <form action="admin.php" method="post"
      enctype="multipart/form-data">
      <label for="username">Username</label>
      <input type="text" name="username" required="required"/><br>
      <label for="streetAddress">Street address</label>
      <input type="text" name="streetAddress" required="required"/><br>
      <label for="postCode">Postal code</label>
      <input type="number" name="postCode" required="required" min=0 max=99999/><br>
      <label for="country">Country</label>
      <select id="country" name="country" required>
          <?php include 'countryList.php'; ?>
          <option selected="selected">Norway</option>
      </select></br>
      <label for="email">E-mail</label>
      <input type="email" name="email" required="requried"/><br>
      <label for="password">Password</label>
      <input type="password" name="password" required="required"/><br>
      <label for="userLevel">User level.</label>    
      <select id="userLevel" name="userLevel" required>
          <option value="0">0 - Normal user</option>
          <option value="1">1 - Worker</option>
          <option value="2">2 - admin</option>
      </select></br>
      <input type="submit" name="submit" value="Add new user">
  </form>
</div>