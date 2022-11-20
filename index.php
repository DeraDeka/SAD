<?php
    // Establish Connection to SQL Database
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="sad_db"; // <--- Name of Database to connect with
    $link=mysqli_connect($servername,$username,$password,$dbname);
    $con=mysqli_select_db($link,$dbname);
    // Start Session
    session_start();
    // Check if user is logged on, redirect user to the proper page if logged on
    if(isset($_SESSION['username']))
    { 
        if($_SESSION['type']=="Admin"){ header('Location: admin.php'); } // Go to admin page is user type is "Admin"
        if($_SESSION['type']=="Viewer"){ header('Location: viewer.php'); } // Go to viewer page is user type is "Viewer"
    }
?>

<html> <!-- HTML (START)-->
<body>
    <h1>Login</h1>
      <form method="post"> <!-- Form (Start)-->
        <input type="text" required name="username">
        <label>Username</label><br>

        <input type="password" required name="password">
        <label>Password</label><br>

        <input type="submit" value="Login" name="button">
      </form> <!-- Form (END)-->
</body>
</html> <!-- HTML (END)-->

<?php
    if(isset($_POST["button"]))
    {
        $inputUser = htmlentities($_POST['username']);
        $inputPassword = htmlentities($_POST['password']);

        $res=mysqli_query($link,"select * from account where username='$_POST[username]' AND password='$_POST[password]'");
        while($row=mysqli_fetch_array($res))
        {
            if($inputUser == $row["username"] && $inputPassword == $row["password"]) // if login succeeds
            { 
                $_SESSION['username'] = htmlentities($_POST['username']);
                $_SESSION['type'] = $row["type"];
                // Redirect to appropiate page based on account 'type'
                if($_SESSION['type']=="Admin"){ header('Location: admin.php'); }
                else if($_SESSION['type']=="Viewer"){ header('Location: viewer.php'); }
            }
        }
        echo '<script>alert("Username or password is incorrect")</script>';
    }
?>