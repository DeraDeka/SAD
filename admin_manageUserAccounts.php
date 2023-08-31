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
.bg-nav{
    background-color: #cfd1d0;
}
.colgroup1{
  position: absolute;
  left: 17%;
}
.colgroup1b{
  position: absolute;
  left: 31%;
}
.colgroup1c{
  position: absolute;
  left: 45%;
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
    </nav>
    <!-- Search Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-nav">
    <form method="post">
        <label class="mb-1 noselect">&nbsp&nbspFilter Display by User Type</label>
        <label class="mb-1 noselect colgroup1">Search User (Enter first name on the first textbox and lastname on the second textbox)</label><br>&nbsp
        <select name="filterType">
                <option value="All">All</option>
                <option value="Admin">Admin</option>
                <option value="Viewer">Viewer</option>
        </select>&nbsp<button type="submit" name="search1" formnovalidate>Filter Display</button>
        <input class="colgroup1" type="text" required name="searchFN">
        <input class="colgroup1b" type="text" required name="searchLN">
        <button class="colgroup1c" type="submit" name="search2">Search User</button>
    </form>
    </nav>
    <!-- Table -->
    <div><!-- Div for Table (Start) -->
        <form method="post">
            <table class="table text-center table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="align-middle" scope="col">ID</th>
                        <th class="align-middle" scope="col">Username</th>
                        <th class="align-middle" scope="col">Password</th>
                        <th class="align-middle" scope="col">Type</th>
                        <th class="align-middle" scope="col">Name of the user (Last name, first name)</th>
                        <th class="align-middle" scope="col">
                            <label class="whiteFont">Operations</label><br>
                            <button type="submit" class="btn btn-primary" name="create">Create New Account</button>
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
                    <td><?php echo $row->id?></td>
                    <td><?php echo $row->username?></td>
                    <td><?php echo $row->password?></td>
                    <td><?php echo $row->type?></td>
                    <td><?php echo $row->last_name?>, <?php echo $row->first_name?></td>
                    <td>
                        <button class="btn btn-warning" type="submit" value="<?php echo $row->id?>" name="edit">Edit</button>
                        <button class="btn btn-danger" type="submit" value="<?php echo $row->id?>" name="delete">Delete</button>
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

<!-- PHP "Search" Function Codes-->
<?php 
    // Filter user type
    if(isset($_POST["search1"]))//filterType
    {
        $_SESSION['searchParameter1'] = $_POST["filterType"];

        if($_SESSION['searchParameter1'] == "All"){ $_SESSION['query'] = "SELECT * FROM account"; }

        else { $_SESSION['query'] = "SELECT * FROM account WHERE type='$_SESSION[searchParameter1]'"; }

        header('Location: admin_manageUserAccounts.php');
        ob_end_flush();
    }
    // Search user
    if(isset($_POST["search2"]))//filterType
    {
        $_SESSION['searchParameter1'] = $_POST["searchFN"];
        $_SESSION['searchParameter2'] = $_POST["searchLN"];

        $_SESSION['query'] = "SELECT * FROM account WHERE first_name='$_SESSION[searchParameter1]' AND last_name='$_SESSION[searchParameter2]'";

        header('Location: admin_manageUserAccounts.php');
        ob_end_flush();
    }
?>

<!-- PHP Add, Edit, Delete Button Function Codes-->
<?php 
    // Add Button
    if(isset($_POST["create"]))
    {
        header('Location: createUA.php');
        ob_end_flush();
    }
    // Edit Button
    if(isset($_POST["edit"]))
    {
        $_SESSION['id'] = $_POST["edit"];
        header('Location: editUA.php');
        ob_end_flush();
    }
    // Delete Button
    if(isset($_POST["delete"]))
    {
        $_SESSION['id'] = $_POST["delete"];
        header('Location: deleteUA.php');
        ob_end_flush();
    }
?>