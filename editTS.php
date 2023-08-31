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
$id = $_SESSION['id'];
$title = '';
$type = '';
$members = '';
$year = '';
$prog_lang = '';
$details = '';
$dL_link = '';

$sqlQuery = "SELECT * FROM study WHERE id = '$id'";
$res = $link->query($sqlQuery);
while($col=mysqli_fetch_array($res))
{ 
        $title = $col["title"];
        $type = $col["type"];
        $members = $col["members"];
        $year = $col["year"];
        $prog_lang = $col["prog_lang"];
        $details = $col["details"];
        $dL_link = $col["dL_link"];
}
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
    <title>Edit Study</title>
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
  top: 5%;
  left: 27%;
  width: 600px;
  height: 575px;
}
.titlelabel{
    position:absolute;
    left: 15px;
}
.titleInputbox{
    width: 565px;
    position:absolute;
    left: 15px;
}
.typelabel{
    position:absolute;
    left: 15px;
}
.typeSelectBox{
    width: 123px;
    position:absolute;
    left: 15px;
}
.yearlabel{
    position:absolute;
    left: 207px;
}
.yearInputbox{
    width: 120px;
    position:absolute;
    left: 207px;
}
.progLanglabel{
    position:absolute;
    left: 385px;
}
.progLangInputbox{
    width: 170px;
    position:absolute;
    left: 385px;
}
.memberlabel{
    position:absolute;
    left: 15px;
}
.memberInputbox{
    width: 565px;
    position:absolute;
    left: 15px;
    resize: none;
}
.detaillabel{
    position:absolute;
    left: 15px;
}
.detailInputbox{
    width: 565px;
    position:absolute;
    left: 15px;
    resize: none;
}
.DLlabel{
    position:absolute;
    left: 15px;
}
.DLInputbox{
    width: 565px;
    position:absolute;
    left: 15px;
}
</style>
<body style="background-color:#878787;">
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <div class="InputForm container border loginForm rounded border-dark bg-light"> <!-- Login Form Containter (start) -->
        <br>
        <h1 class="noselect text-center">Edit Study</h1>
        <form method="post"> <!-- Form (Start)-->
            <!-- Title -->
            <label class="mb-1 noselect titlelabel">Title of the study</label><br>
            <input class="mb-3 titleInputbox" type="text" required name="title" value="<?php echo $title?>"><br><br>  
            <!-- Type, Year, Programming Language -->
            <label class="mb-2 noselect typelabel">Type of the study</label>
            <label class="mb-2 noselect yearlabel">Year of the study</label>
            <label class="mb-2 noselect progLanglabel">Programming Language</label><br>  
            <select class="mb-3 typeSelectBox" name="type">
                <option value="<?php echo $type?>"><?php echo $type?></option>
                <option value="Baby Thesis">Baby Thesis</option>
                <option value="Capstone">Capstone</option>
            </select>
            <input class="mb-3 yearInputbox" type="text" required name="year" value="<?php echo $year?>"> 
            <input class="mb-3 progLangInputbox" type="text" required name="progLang" value="<?php echo $prog_lang?>"><br><br>  
            <!-- Members -->
            <label class="mb-1 noselect memberlabel">Members of the study</label><br>
            <textarea maxlength="250" rows = "2" class="mb-3 memberInputbox" type="text" required name="member"><?php echo $members?></textarea><br><br><br>  
            <!-- Details of the study -->
            <label class="mb-1 noselect detaillabel">Details/Summary of the study (Max 500 characters)</label><br>
            <textarea maxlength="250" rows = "3" class="mb-3 detailInputbox" type="text" required name="detail"><?php echo $details?></textarea><br><br><br><br>  
            <!-- Download Link -->
            <label class="mb-1 noselect DLlabel">Download Link</label><br>
            <input class="mb-3 DLInputbox" type="text" required name="link" value="<?php echo $dL_link?>">

            <!-- Buttons -->
            <br><br>
            <button type="submit" class="btn btn-dark" name="cancel" formnovalidate>Cancel</button>
            <button type="submit" class="btn btn-primary" name="edit">Edit Study</button>
        </form> <!-- Form (END)-->
    </div>
</body>
</html>

<!-- PHP Button Function Codes-->
<?php 
    // Cancel button
    if(isset($_POST["cancel"]))
    {
        header('Location: admin_manageStudies.php');
        ob_end_flush();
    }
    // Edit button
    if(isset($_POST["edit"]))
    {
        $sqlQuery = "UPDATE study SET title='$_POST[title]', type='$_POST[type]', members='$_POST[member]', year='$_POST[year]', prog_lang='$_POST[progLang]', details='$_POST[detail]', dL_link='$_POST[link]' WHERE id = '$id'";
        $res = $link->query($sqlQuery);

        // Codes for recording actions for history log //
        date_default_timezone_set("Asia/Manila");
        $date = date("M d, Y");
        $time = date("h:i:s a");
        // Save action in the Database
        $log = "[".$_SESSION['UserId']."] ".$_SESSION['username']." (".$_SESSION['type'].") Updated an account: [".$id."] ".$_POST["title"]." (".$_POST["type"].")";
        $sqlQuery = "INSERT INTO history VALUES (DEFAULT,'$date','$time','$log')";
        $res = $link->query($sqlQuery);

        header('Location: admin_manageStudies.php');
        ob_end_flush();
    }
?>