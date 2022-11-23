<?php
// Start Session
session_start();
$user = $_SESSION['username'];
$type = $_SESSION['type'];
// Check active username and account type
if(isset($user)==0){ header('Location: index.php'); } // Go to login form if not logged in
if($_SESSION['type']=="Admin"){ header('Location: admin.php'); }  // Go to viewer page if active account type is "Admin"
?>

<html> <!-- HTML (START)-->
<body>
    <h1>Viewer</h1>
    <form method="post"><input type="submit" name="logout" value="Logout"></form>
</body>
</html> <!-- HTML (END)-->

<?php // Logout button
    if(isset($_POST["logout"]))
    {
        session_destroy();
        header('Location: index.php'); 
    }
?>