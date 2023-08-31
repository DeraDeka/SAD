<?php
// Connect  Database
include 'connectDB.php';
// OB Start & Start Session
ob_start();
session_start();
// Initialize "GLOBAL" variables
$user = $_SESSION['username'];
$type = $_SESSION['type'];
// Variables for this file
$_SESSION['id'] = -1;
// Check active username and account type
if(isset($user)==0){ header('Location: index.php'); } // Go to login form if not logged in
if($_SESSION['type']=="Viewer"){ header('Location: viewer_index.php'); } // Go to viewer page if active account type is "Viewer" 
?>

<!DOCTYPE html>
<html lang="en"> <!-- HTML (START)-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
.whiteFont{
    color:white;
}
.btn-nav {
	display: inline-block;
	font-weight: 400;
	color: #212529;
	text-align: center;
	border: 1px solid transparent;
	padding: .375rem .75rem;
	font-size: 1rem;
	line-height: 1.5;
	border-radius: .25rem;
	color: #fff;
	background-color: #007bff;
    width: 205px;
}
.btn-logout {
	display: inline-block;
	font-weight: 400;
	color: #212529;
	text-align: center;
	border: 1px solid transparent;
	padding: .375rem .75rem;
	font-size: 1rem;
	line-height: 1.5;
	border-radius: .25rem;
	color: #fff;
	background-color: red;
    width: 205px;
}
</style>
<body>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Body -->
    <br><h1 class="d-flex justify-content-around">Welcome! <?php echo $user?></h1><br>
    <!-- Admin Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <form method="post">
        <input class="mb-1 btn-nav position-relative" type="submit" value="Manage User Accounts" name="navb1">
        <input class="mb-1 btn-nav position-relative" type="submit" value="Manage Studies" name="navb2">
        <input class="mb-1 btn-nav position-relative" type="submit" value="Verify New User Accounts" name="navb3">
        <input class="mb-1 btn-nav position-relative" type="submit" value="View Logs" name="navb4">
        <input class="mb-1 btn-logout position-relative" type="submit" value="Logout" name="navb5">
    </form>
    </nav><br>
    <!-- Table -->
    <div><!-- Div for Table (Start) -->
        <form method="post">
            <table class="table text-center table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="align-middle" scope="col">Username</th>
                        <th class="align-middle" scope="col">Password</th>
                        <th class="align-middle" scope="col">Name of the user (Last name, first name)</th>
                        <th class="align-middle" scope="col">
                            <label class="whiteFont">Operations</label><br>
                        </th>
                     </tr>
                </thead>
                <tbody>
                <?php
                    $sqlQuery = $_SESSION['query'];
                    $res = $link->query($sqlQuery);
                    while($row =mysqli_fetch_object($res)){
                 ?>
                <tr>
                    <td><?php echo $row->username?></td>
                    <td><?php echo $row->password?></td>
                    <td><?php echo $row->last_name?>, <?php echo $row->first_name?></td>
                    <td>
                        <button class="btn btn-primary" type="submit" value="<?php echo $row->id?>" name="accept">Accept</button>
                        <button class="btn btn-danger" type="submit" value="<?php echo $row->id?>" name="reject">Reject</button>
                </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </form>
    </div><!-- Div for Table (END) -->
</body>
</html> <!-- HTML (END)-->

<!-- PHP Navigation Button Function Codes-->
<?php 
    // Manage User Account button
    if(isset($_POST["navb1"]))
    {
        $_SESSION['query'] = "SELECT * FROM account";
        header('Location: admin_manageUserAccounts.php');
        ob_end_flush();
    }
    // Manage studies button
    if(isset($_POST["navb2"]))
    {
        $_SESSION['query'] = "SELECT * FROM study";
        header('Location: admin_manageStudies.php');
        ob_end_flush();
    }
    // Verify User button
    if(isset($_POST["navb3"]))
    {
        $_SESSION['query'] = "SELECT * FROM verification_list";
        header('Location: admin_verifyUser.php');
        ob_end_flush();
    }
    // View Log/History button
    if(isset($_POST["navb4"]))
    {
        $_SESSION['query'] = "SELECT * FROM history";
        header('Location: admin_viewLogs.php');
        ob_end_flush();
    }
    // Logout button
    if(isset($_POST["navb5"]))
    {
        session_destroy();
        header('Location: index.php');
        ob_end_flush();
    }
?>

<!-- PHP Accept, Reject Button Function Codes-->
<?php 
    // Accept Button
    if(isset($_POST["accept"]))
    {
        $un = '';
        $pw = '';
        $type = 'Viewer';
        $fn = '';
        $ln = '';

        $res=mysqli_query($link,"select * from verification_list WHERE id = '$_POST[accept]'");
        while($row=mysqli_fetch_array($res))
        {
            $un = $row["username"];
            $pw = $row["password"];
            $fn = $row["first_name"];
            $ln = $row["last_name"];
        }

        // Insert into the database
        $sqlQuery = "INSERT INTO account VALUES (DEFAULT, '$un', '$pw', '$type', '$fn', '$ln')";
        $res = $link->query($sqlQuery);

        // Codes for recording actions for history log //
        date_default_timezone_set("Asia/Manila");
        $date = date("M d, Y");
        $time = date("h:i:s a");
        // Save action in the Database
        $log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Verified the account of ".$fn." ".$ln;
        $sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
        $res = $link->query($sqlQuery);

        $sql = "DELETE FROM verification_list WHERE id = '$_POST[accept]'";
        $res = $link->query($sql);

        header('Location: admin_verifyUser.php');
        ob_end_flush();
    }
    // Reject Button
    if(isset($_POST["reject"]))
    {
        $fn = '';
        $ln = '';

        $res=mysqli_query($link,"select * from verification_list WHERE id = '$_POST[reject]'");
        while($row=mysqli_fetch_array($res))
        {
            $fn = $row["first_name"];
            $ln = $row["last_name"];
        }

        // Codes for recording actions for history log //
        date_default_timezone_set("Asia/Manila");
        $date = date("M d, Y");
        $time = date("h:i:s a");
        // Save action in the Database
        $log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Rejected the account of ".$fn." ".$ln;
        $sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
        $res = $link->query($sqlQuery);

        $sql = "DELETE FROM verification_list WHERE id = '$_POST[reject]'";
        $res = $link->query($sql);
        header('Location: admin_verifyUser.php');
        ob_end_flush();
    }
?>