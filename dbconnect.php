<?php

    $server="localhost";
    $username="root";
    $password="";
    $database="todolist";

    $connection=mysqli_connect($server, $username, $password, $database);

    if(!$connection)
        die("failed to connect!\n" .mysqli_connect_error());
?>