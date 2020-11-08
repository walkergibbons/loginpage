<?php
// Bob Allen
// IST 351
// Session Example

// adapted from http://tutorialjinni.com
//
// For information about sessions expiring, see:
// http://bytes.com/topic/php/insights/889606-setting-timeout-php-sessions

session_start();

if (isset ($_GET['newAccount']))
{
?>
<h1>Create an Account</h1><br>
<form method="post" action=".">
  First name:<br>
  <input type="text" name="firstname"><br>
  Last name:<br>
  <input type="text" name="lastname" ><br><br>
  User name:<br>
  <input type="text" name="username" >
<?php
        if (isset($_GET['badUserName'])) echo "Username must be valid";
?>

  <br><br>
  Password:<br>
  <input type="password" name="password1" >
<?php
        if (isset($_GET['badPassword'])) echo "Password must be valid";
?>


<br><br>
  Re-enter your Password:<br>
  <input type="password" name="password2" ><br><br>
  <input type="submit" value="Create Account">
</form>
<?php
die("Create a new account.");
}


// Check for new account creation
if (isset ($_POST['password2']))
{
        if (strlen($_POST['username']) == 0)
        {
                header("Location: .?newAccount=true&badUserName=true");
                exit();
        }

        if (strlen($_POST['password1']) == 0)
        {
                header("Location: .?newAccount=true&badPassword=true");
                exit();
        }

        if ($_POST['password1'] == $_POST['password2'] )
        {
		$md5Pass = md5($_POST['password1']);
		//THIS IS WHERE YOU CHANGE THE DATABASE INFORMATION
                $con = new mysqli('localhost','root','AA869Munchies$$','accounts');
                if ($con->connect_error)
                {
                die('Could not connect to mySQL in account creation: ' . $con->connect_error);
                }

                $sql = "INSERT INTO accountlist (userid, FirstName, LastName, Password) VALUES ('$_POST[username]','$_POST[firstname]', '$_POST[lastname]', '$md5Pass')";

                if (!$con->query($sql)=== TRUE)
                   {
                        echo "<h2>Account was Not created, please try again.</h2><br>";
                   }
                else
                        echo "<h2>Account Created</h2><br>";
         }


        else
        {
                die('Passwords do not match');
        }


}



// CHECK if login form is submitted
if(isset ($_POST["submit"])){
    $username=$_POST["username"];
    $password=$_POST["password"];

// Try to connect with the MySQL Server
$con = new mysqli('localhost','root','AA869Munchies$$','accounts');
if ($con->connect_error)
  {
  die('Could not connect to mySQL: ' . $con->connect_error);
  }

// Process logging in
$md5Password = md5($password);
$sql = "SELECT * FROM accountlist WHERE userid = '" . $username . "' AND Password = '" . $md5Password . "'";


$result = $con->query($sql);

if ($result->num_rows == 1)
{
   echo "<h2>YOU LOGGED IN!</h2><br>";
        $_SESSION["isLoggedIn"]=1;
        //setting a varable so that later I know
        // that this user is logged in
        $_SESSION["uname"]=$username;
        //setting another variable
        $_SESSION["bgcolor"]="lightcyan";
}
else
{
   echo "<h2>LOGIN FAILED!</h2><br>";
}


}

// Check if new color was selected
if (isset($_POST["pickColor"]))
{
        $_SESSION["bgcolor"] = $_POST["pickColor"];
}

// for logout or destroy session
if(isset($_GET["action"])){
    if($_GET["action"]){

        session_unset();
        //unset all session variables

        session_destroy();
        // destroy session
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IST351 Sessions Example</title>
</head>
    <body>
          <?php
               /////////////////  This is really cool.  Note how the PHP if statement is started here, but ended in another php block.
               ////////////////   The html that follows is only included if the php if condition is true.

            if(!$_SESSION["isLoggedIn"]==1){
                // checking the value of isLoggedIn
          ?>

        <div style="margin:auto; margin-bottom: 20px; width:500px; background-color:lightcyan; padding:20px; text-align:center; border:solid;">
        <h1>Our Favorite Sites</h1>
                <h3>Login to see our favorite sites</h3>
        <form action="." method="post">
          <table style="margin:auto; width:400px; border:solid; padding: 20px;">
            <tr>
              <td style="text-align:right;">User Name : </td>
              <td><label for="username"></label>
              <input name="username" type="text" id="username" size="35" /></td>
            </tr>
            <tr>
              <td style="text-align:right;">Password : </td>
              <td><label for="pass"></label>
              <input name="password" type="password" id="pass" size="35" /></td>
            </tr>
            <tr>
              <td colspan="2"><input type="submit" name="submit" id="submit" value="See Favorite Sites" /></td>
            </tr>
            <tr>
                <td colspan="2"><a href=".?newAccount=true">Create Account</a></td>
            </tr>
          </table>
        </form>

        <?php
               /////////////////   Here is the else part of the if started above.
            }
            else{
                                         echo "<div style='margin:auto; margin-bottom: 20px; width:500px; background-color:".$_SESSION['bgcolor']."; padding:20px; text-align:center; border:solid;'>         <h1>Our Favorite Sites</h1>";

                 echo "<h3>Welcome <b><em>".$_SESSION["uname"]."</em></b></h3>";
                    ?>

            <div style='text-align:left; margin-left: 200px; margin-right:0px;'>
                                          <ul>
                                          <li><a href='http://google.com' target='_blank'>Google</a></li>
                                          <li><a href='http://w3schools.com' target='_blank'>W3Schools</a></li>
                                          <li><a href='http://php.net' target='_blank'>PHP</a></li>
                                          <li><a href='page2.php' >My Page 2</a></li>

                                          </ul>
                                          </div>
                  <br />
                                          <br />
                                          Set background color:
                                          <form action="." method="post">
                                              <select name="pickColor" >
                                                  <option value="black">Black</option>
                                                  <option value="white">White</option>
                                                  <option value="yellow">yellow</option>
                                                  <option value="blue">blue</option>
                </select>

                                              <input type="submit" value="Change Color" />
                                          </form>

            <a href='index.php?action=logout'>Logout</a>

         <?php
            ////////////////////  And here is the end of the php if statment.
            }
         ?>

</div>
</body>
</html>
