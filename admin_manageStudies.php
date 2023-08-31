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
  left: 21%;
}
.colgroup1b{
  position: absolute;
  left: 35%;
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
        <label class="mb-1 noselect">&nbsp&nbspFilter Display by Thesis Study Type</label>
        <label class="mb-1 noselect colgroup1">Search Title (Enter the title on the textbox)</label><br>&nbsp
        <select name="filterType">
                <option value="All">All</option>
                <option value="Baby Thesis">Baby Thesis</option>
                <option value="Capstone">Capstone</option>
        </select>&nbsp<button type="submit" name="search1" formnovalidate>Filter Display</button>
        <input class="colgroup1" type="text" required name="searchT">
        <button class="colgroup1b" type="submit" name="search2">Search Title</button>
    </form>
    </nav>
    <!-- Table -->
    <div><!-- Div for Table (Start) -->
        <form method="post">
            <table class="table text-center table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="align-middle" scope="col">ID</th>
                        <th class="align-middle" scope="col">Title</th>
                        <th class="align-middle" scope="col">Type</th>
                        <th class="align-middle" scope="col">Year of the study</th>
                        <th class="align-middle" scope="col">Programming Language</th>
                        <th class="align-middle" scope="col">
                            <label class="whiteFont">Operations</label><br>
                            <button type="submit" class="btn btn-primary" name="create">Add New Study</button>
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
                    <td><?php echo $row->title?></td>
                    <td><?php echo $row->type?></td>
                    <td><?php echo $row->year?></td>
                    <td><?php echo $row->prog_lang?></td>
                    <td>
                        <button class="btn btn-success" type="submit" value="<?php echo $row->id?>" name="view">View</button>
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
    // Filter study type
    if(isset($_POST["search1"]))//filterType
    {
        $_SESSION['searchParameter1'] = $_POST["filterType"];

        if($_SESSION['searchParameter1'] == "All"){ $_SESSION['query'] = "SELECT * FROM study"; }

        else { $_SESSION['query'] = "SELECT * FROM study WHERE type='$_SESSION[searchParameter1]'"; }

        header('Location: admin_manageStudies.php');
        ob_end_flush();
    }
    // Search study
    if(isset($_POST["search2"]))//filterType
    {
        $_SESSION['searchParameter1'] = $_POST["searchT"];

        $_SESSION['query'] = "SELECT * FROM study WHERE title='$_SESSION[searchParameter1]'";

        header('Location: admin_manageStudies.php');
        ob_end_flush();
    }
?>

<!-- PHP Add, Edit, Delete Button Function Codes-->
<?php
    // Add Button
    if(isset($_POST["create"]))
    {
        header('Location: createTS.php');
        ob_end_flush();
    }
    // Edit Button - unfinished
    if(isset($_POST["edit"]))
    {
        $_SESSION['id'] = $_POST["edit"];
        header('Location: editTS.php');
        ob_end_flush();
    }
    // Delete Button
    if(isset($_POST["delete"]))
    {
        $_SESSION['id'] = $_POST["delete"];
        header('Location: deleteTS.php');
        ob_end_flush();
    }
    // View Button
    if(isset($_POST["view"]))
    {
        // Codes for recording actions for history log //
        // Prepare variables
        $id = $_POST["view"];
        $title = '';
        $type = '';
        $sqlQuery = "SELECT * FROM study WHERE id = '$id'";
        $res = $link->query($sqlQuery);
        while($col=mysqli_fetch_array($res))
        {
                $title = $col["title"];
                $type = $col["type"];
        }
        date_default_timezone_set("Asia/Manila");
        $date = date("M d, Y");
        $time = date("h:i:s a");
        // Save action in the Database
        $log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Viewed a study: [".$id."] ".$title." (".$type.")";
        $sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
        $res = $link->query($sqlQuery);

        // View study //
        $_SESSION['id'] = $_POST["view"];
        header('Location: viewTS.php');
        ob_end_flush();
    }
?>
