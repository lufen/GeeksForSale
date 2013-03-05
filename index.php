<?php
require_once 'sessionStart.php';
if(isset($_GET['logout'])){
  session_unset();
}
?>
<?php
include 'Geeksforsaletop.php';
?>
<div id="content">
</div>
</BODY>
</HTML>
