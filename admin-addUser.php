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
    <input type="text" name="country" required="required"/><br>
    <label for="email">E-mail</label>
    <input type="email" name="email" required="requried"/><br>
    <label for="password">Password</label>
    <input type="password" name="password" required="required"/><br>
    <label for="userLevel">User level. 0 for regular user, 1 for workers and 2 for administrators</label><br>
    <input type="number" name="userLevel" required="required" min=0 max=2/><br>
    <input type="submit" name="submit" value="Add new user">
  </form>