<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
   <HEAD>
      <TITLE>Geeks For Sale</TITLE>
      <link rel="stylesheet" type="text/css" href="StyleIndex.css"/>
   </HEAD>
   <BODY>
   	   <div id="header">
   	   	<h1>
               <?php
   			      echo "Geeks for sale!!!";
   		       ?>
            </h1>
			<s>
      	    <form class="form-wrapper cf">
                 <input type="text" placeholder="Search here..." required>
                 <button type="submit">Search</button>
      		</form>
			</s>
		</div>
   	   
	   <div id="menu">
	   <?php
         // Initate the db connection
         requirce once 'db.php';
      ?>
	   </div>
   	   
   	  

   </BODY>
</HTML>