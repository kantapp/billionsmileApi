<?php
    error_reporting(0);
    $servername="localhost";
    $username="root";
    $password="";
    $database="kantappc_billionsmile";

    $dbcon=new mysqli($servername,$username,$password,$database);
    if($dbcon->connect_error)
    {
        die("Failed To connect MySQL :".$dbcon->connect_error);
    }
    
    function info()
    {
        phpinfo();
    }