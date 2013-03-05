<?php
include 'Geeksforsaletop.php';
?> 

<div = "content">
    <p> <br>Add a new product to
      <form action="admin.php" method="post"
      enctype="multipart/form-data">
        <select name="subcategory">
          <?php
          $sql = 'select name from subcategory';
          $sth = $db->prepare($sql);
          $sth->execute();
          $sth->setFetchMode(PDO::FETCH_ASSOC);  
          while($row = $sth->fetch()){
            echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
          }
          ?>
        </select><br><br>
        <label for="productName">Name</label>
        <input type="text" name="productName" required="required"/><br>
        <label for=price>Price</label>
        <input type="number" name="price" required="required" min=1 max=99999/><br>
        <label for=picture>Picture</label>
        <input type="file" name="picturefn" required="required"><br>
        <label for="info">Information about the product</label>
        <input type="text" name="info" required="required"/><br>
        <label for="onStock">Number of that product for sale</label>
        <input type="number" name="onStock" required="required" min=0 max=9999/><br>
        <label for="forSale">Is this product for sale? 1 for yes, 0 for no</label>
        <input type="bool" name=forSale required="required" min=0 max=1><br>
        <label for="rabatt">Discount in percentage.</label>
        <input type="number" name=rabatt required="required" min=0 max=99><br>
        <input type="submit" name="submit" value="Add new product">
      </form>
</div>