<?php
    // Connect  Database
    include 'connectDB.php';
    // OB Start & Start Session
    ob_start();
    session_start();
    // Check if user is logged on, redirect user to the proper page if logged on
    if(isset($_SESSION['username']))
    { 
        if($_SESSION['type']=="Admin"){ header('Location: admin_manageUserAccounts.php'); } // Go to admin page is user type is "Admin"
        if($_SESSION['type']=="Viewer"){ header('Location: viewer_index.php'); } // Go to viewer page is user type is "Viewer"
    }
?>

<!DOCTYPE html>
<html lang="en"> <!-- HTML (START)-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<style>
.noselect{ /* Prevent Text Highlight */
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
    -khtml-user-select: none; /* Konqueror HTML */
    -moz-user-select: none; /* Old versions of Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none; /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
}
.loginForm{
  position: absolute;
  top: 25%;
  right: 15%;
  width: 275px;
  height: 315px;
}
.bg-maroon{
  background-color: maroon;
}
</style>
<body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 text-center border border-dark"> <!-- Left Side -->
                <label class="mb-1"> </label><br><br>
                <img class="mb-1" src="images\cssLogo.jpg"><br>
                <h1 class="mb-2 noselect">Online Archive For Thesis Studies for the CCS Department of CRMC</h1>
                <br><br><br><br>
            </div>
            <div class="col-lg-6 text-center border border-dark bg-maroon"> <!-- Right Side -->
                <div class="container border loginForm rounded border-dark bg-light"> <!-- Login Form Containter (start) -->
                <br>
                <h1 class="noselect">Login</h1>
                <form autocomplete="off" method="post"> <!-- Form (Start)-->
                    <label class="mb-1 noselect">Username</label><br>
                    <input class="mb-3" type="text" required name="username"><br>

                    <label class="mb-1 noselect">Password</label><br>
                    <input class="mb-3" type="password" required name="password"><br>
        
                    <input type="submit" value="Login" name="button"><br><br>
                    <a href="http://localhost/SAD/viewer_createAccount.php">Create new account</a>

                </form> <!-- Form (END)-->
                </div> <!-- Login Form Containter (end) -->
            </div>
        </div>
    </div>

</body>
</html> <!-- HTML (END)-->

<?php
    if(isset($_POST["button"]))
    {
        $inputUser = htmlentities($_POST['username']);
        $inputPassword = htmlentities($_POST['password']);
        $userID = -1; // For History recording purposes
        $res=mysqli_query($link,"select * from account where username='$_POST[username]' AND password='$_POST[password]'");
        while($row=mysqli_fetch_array($res))
        {
            if($inputUser == $row["username"] && $inputPassword == $row["password"]) // if login succeeds
            { 
                $_SESSION['username'] = htmlentities($_POST['username']);
                $_SESSION['type'] = $row["type"];
                $_SESSION['UserId'] = $row["id"];

                // Codes for recording actions for history log //
                date_default_timezone_set("Asia/Manila");
                $date = date("M d, Y");
                $time = date("h:i:s a");
                // Save action in the Database
                $log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Logged in";
                $sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
                $res = $link->query($sqlQuery);

                // Redirect to appropiate page based on account 'type'
                if($_SESSION['type']=="Admin")
                { 
                    $_SESSION['query'] = "SELECT * FROM study";
                    header('Location: admin_manageStudies.php');
                    ob_end_flush();
                }
                else if($_SESSION['type']=="Viewer")
                { 
                    $_SESSION['query'] = "SELECT * FROM study";
                    $_SESSION['duplicate'] = -1;
                    header('Location: viewer_index.php');
                    ob_end_flush();
                }
            }
        }
        echo '<script>alert("Username or password is incorrect")</script>';
    }
?>