<?php
// Connect  Database
include 'connectDB.php';
// OB Start & Start Session
ob_start();
session_start();
// Initialize "GLOBAL" variables
$user = $_SESSION['username'];
$type = $_SESSION['type'];
// Check active username and account type
if(isset($user)==0){ header('Location: index.php'); } // Go to login form if not logged in
if($_SESSION['type']=="Viewer"){ header('Location: viewer_index.php'); } // Go to viewer page if active account type is "Viewer" 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User Account</title>
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
.InputForm{
  position: absolute;
  top: 15%;
  left: 34%;
  width: 450px;
  height: 450px;
}
.lb2{
  position: absolute;
  left: 45%;
}
body{
    background-color:#878787;
}
</style>
<body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <div class="InputForm container border loginForm rounded border-dark bg-light"> <!-- Login Form Containter (start) -->
        <br>
        <h1 class="noselect text-center mb-1">Create New Account</h1>
        <form method="post"> <!-- Form (Start)-->

            <label class="mb-1 noselect"><b>User Information</b></label><br>
            <label class="mb-1 noselect">First Name</label>
            <label class="mb-1 noselect lb2">Last Name</label><br>
            <input class="mb-3" type="text" required name="fn">
            <input class="mb-3" type="text" required name="ln"><br>

            <label class="mb-1 noselect"><b>Account Information</b></label><br>
            <label class="mb-1 noselect">Username</label>
            <label class="mb-1 noselect lb2">Password</label><br>
            <input class="mb-3" type="text" required name="username">
            <input class="mb-3" type="text" required name="password"><br>
        
            <label class="mb-1 noselect">User type</label><br>
            <select class="mb-3" name="usertype">
                <option value="Viewer">Viewer</option>
                <option value="Admin">Admin</option>
            </select><br><br><br>
            <button type="submit" class="btn btn-dark" name="cancel" formnovalidate>Cancel</button>
            <button type="submit" class="btn btn-primary" name="create">Create New Account</button>

        </form> <!-- Form (END)-->
    </div>
</body>
</html>

<!-- PHP Button Function Codes-->
<?php 
    // Cancel button
    if(isset($_POST["cancel"]))
    {
        header('Location: admin_manageUserAccounts.php');
        ob_end_flush();
    }
    // Create button
    if(isset($_POST["create"]))
    {
        $duplicate = 0; // check username duplicate
        $duplicate2 = 0; // check if person already has an account

        // check username duplicate in user account list
        $res=mysqli_query($link,"select * from account where username='$_POST[username]'");
        while($row=mysqli_fetch_array($res))
        {   
            if($row["username"] == $_POST["username"])
            { $duplicate = 1; }   
        }
        // check username duplicate in verification list
        $res=mysqli_query($link,"select * from verification_list where username='$_POST[username]'");
        while($row=mysqli_fetch_array($res))
        {   
            if($row["username"] == $_POST["username"])
            { $duplicate = 1; }   
        }
        // check if person already has an account in user account list
        $res=mysqli_query($link,"select * from account where first_name='$_POST[fn]' AND last_name='$_POST[ln]'");
        while($row=mysqli_fetch_array($res))
        {
            if(($row["first_name"] == $_POST["fn"]) && ($row["last_name"] == $_POST["ln"]))
            { $duplicate2 = 1; }
        }
        // check if person already has an account in verification list
        $res=mysqli_query($link,"select * from verification_list where first_name='$_POST[fn]' AND last_name='$_POST[ln]'");
        while($row=mysqli_fetch_array($res))
        {
            if(($row["first_name"] == $_POST["fn"]) && ($row["last_name"] == $_POST["ln"]))
            { $duplicate2 = 1; }
        }

        if(($duplicate == 0) && ($duplicate2 == 0))
        {
            // Create account
            $sqlQuery = "INSERT INTO account VALUES (DEFAULT, '$_POST[username]', '$_POST[password]', '$_POST[usertype]', '$_POST[fn]', '$_POST[ln]')";
            $res = $link->query($sqlQuery);

            // Codes for recording actions for history log //
            date_default_timezone_set("Asia/Manila");
            $date = date("M d, Y");
            $time = date("h:i:s a");
            // Get latest account's ID
            $recordID = -1;
            $sqlQuery ="SELECT MAX(id) AS id FROM account";
            $res = $link->query($sqlQuery);
            while($col=mysqli_fetch_array($res)){ $recordID = $col["id"]; }
            // Save action in the Database
            $log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Created a new account: [".$recordID."] ".$_POST["username"]." (".$_POST["usertype"].")";
            $sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
            $res = $link->query($sqlQuery);

            header('Location: admin_manageUserAccounts.php');
            ob_end_flush();
        }
        else
        {  
            echo '<script>alert("Cannot create new account\nThe user might already have an account or username is already taken")</script>';   
            ob_end_flush();
        }
    }
?>