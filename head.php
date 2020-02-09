<?php
    #ini_set('display_errors','0');
    $message = '';
    $bootstrapColors=array("primary", "secondary", "success", "danger","warning","info","dark");
    #$GLOBALS['username']='';
    #session_start();
    #$_SESSION["username"];
    $db = new mysqli('localhost:3306', 'lyc', '90034606', 'wegmansdb');
    if ($db->connect_error){
        $message = $db->connect_error;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wegcipie</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src = "./js/jQuery.js" type = "text/javascript"></script>
    <script src = "./js/bootstrap.bundle.min.js" type = "text/javascript"></script>
    <script src = "./js/script.js" type = "text/javascript"></script>
</head>