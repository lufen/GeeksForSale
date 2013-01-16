<?php
require_once "db.php";
 $sql = "Select * from productcategory";
 $sth = $db->prepare($sql);
 $sth->execute();
 $sth->setFetchMode(PDO::FETCH_ASSOC);  
 $array = array();
 echo "<br>";
 while($row = $sth->fetch()){
    $array[(string)$row['categoryName']] = $row['id'];
    $print = "<a href=\"productcategory.php?id=".$row['id']."\">".$row['categoryName']."</a><br>";
    echo $print;
 }
?>