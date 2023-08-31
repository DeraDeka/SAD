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
  height: 415px;
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

    <div class="InputForm container border loginForm rounded border-dark bg-light text-center"> <!-- Login Form Containter (start) -->
        <br>
        <h1 class="noselect text-center mb-1">Account succesfully created and awaiting verification!<br>Your teacher will notify you if your account is verified</h1>
        <br><br>
        <form method="post"> <!-- Form (Start)-->
            <button type="submit" class="btn btn-primary" name="cancel" formnovalidate>Return to login page</button>
        </form> <!-- Form (END)-->
    </div>
</body>
</html>

<!-- PHP Button Function Codes-->
<?php 
    // Return button
    if(isset($_POST["cancel"]))
    {
        header('Location: index.php');
        ob_end_flush();
    }
?>