<?php

    $alert=false;
    $wrong_pass=false;
    $exists=false;

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include 'dbconnect.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword =$_POST['cpassword'];

        if(($password==$cpassword)){
            $hashPass = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`,`password`, `date`) VALUES ('$username','$hashPass', current_timestamp())";

            $result = mysqli_query($connection,$sql);

            if($result){ 
                $alert=true;
            }
            else{
                $exists=true;
            } 
        }

        else if($password!=$cpassword){
            $wrong_pass=true;
        }
    }

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="./image/fav.jpg">
    <title>To do list</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/login.css">
</head>

<body>

    <div class="container mb-3 form">
        <h1>
            <center>Sign Up</center>
        </h1>
        <img src="./image/flower.png" alt="" class="img1">
        <img src="./image/flower.png" alt="" class="img2">

        <?php
            if($alert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successfully Registered!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }

            if($wrong_pass){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Password did not match!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }

            if($exists){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Username already exists!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }
        ?>
        <form action="register.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" 
            required="required"
            aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"
            required="required">
        </div>
        <div class="form-group">
            <label for="cpassword">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" name="cpassword"
            required="required">
            <small id="emailHelp" class="form-text text-muted">Make sure to type the same password</small>
        </div>
        <br>
        <button type="submit" class="btn btn-sm btn-light">Sign Up <img src="./image/login.png" width="18" height="18"></button>
        <p><center>Already have an account?</center></p>
        <a href="index.php"><center>SignIn</a></center></p>
     </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>