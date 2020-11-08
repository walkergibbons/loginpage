<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IST351 Sessions Example</title>
</head>
<body>
<?php
// adapted from http://tutorialjinni.com
session_start();

// are you logged in?
if(isset($_SESSION["uname"])){
                echo "<div style='margin:auto; margin-bottom: 20px; width:500px; background-color:".$_SESSION['bgcolor']."; padding:20px; text-align:center; border:solid;'>   <h1>Our Favorite Sites</h1>";
                echo "<h3>Welcome <b><em>".$_SESSION["uname"]."</em></b></h3>";
?>
   <h3>This is my fancy Page 2</h3>

   Page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2, page 2.<br /><br />
   <a href=".">Back to Main</a>
   </div>
<?php
}
else
{
?>
   <h3>This is my fancy Page 2</h3>
   <div>
   You need to login to see this fancy page.<br />
   <a href=".">Go Login</a>
   </div>
<?php
}
?>

</body>
</html>
