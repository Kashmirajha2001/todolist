<?php

    include 'dbconnect.php';

    session_start();
    if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
        header("location: index.php");
        exit;
      }

      if(isset($_GET['complete'])){
        $sno = $_GET['complete'];
        $complete = true;
        $sql = "UPDATE `list` SET `complete` =NOT `complete` WHERE `sno` = $sno";
        $result = mysqli_query($connection, $sql);
        if ($result) {
          header("Location: home.php"); // Redirect back to the original page
        } else {
          echo "Error updating task completion status: " . mysqli_error($connection);
        }
      }
?>