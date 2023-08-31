<?php

    // Establish Connection to SQL Database
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="sad_db"; // <--- Name of Database to connect with
    $link=mysqli_connect($servername,$username,$password,$dbname);
    $con=mysqli_select_db($link,$dbname);

?>