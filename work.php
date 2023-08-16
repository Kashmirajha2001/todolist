<?php
    $insert=false;
    $delete=false;

    include 'dbconnect.php';

    session_start();
    $user = $_SESSION['username'];
    
    if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
        header("location: index.php");
        exit;
    }

    if(isset($_GET['delete'])){
      $sno = $_GET['delete'];
      $delete = true;
      $sql = "DELETE FROM `customlist` WHERE `sno` = $sno AND `name`='work'";
      $result = mysqli_query($connection, $sql);
    }

    if(isset($_GET['complete'])){
        $sno = $_GET['complete'];
        $complete = true;
        $sql = "UPDATE `customlist` SET `complete` =NOT `complete` WHERE `sno` = $sno";
        $result = mysqli_query($connection, $sql);
        if ($result) {
          header("Location: work.php"); // Redirect back to the original page
        } else {
          echo "Error updating task completion status: " . mysqli_error($connection);
        }
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $content =$_POST["content"];

        $sql = "INSERT INTO `customlist` (`user`, `name`,`content`) VALUES ('$user', 'work','$content')";

        $result = mysqli_query($connection, $sql);
   
        if($result){ 
            $insert = true;
        }
        else{
            echo "The record was not inserted successfully because of this error ---> ". mysqli_error($connection);
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

    <link rel="stylesheet" href="./css/custom.css">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>

    <div class="container mb-3 form">
        <h1>
            <center>Work-List</center>
        </h1>
        <img src="./image/flower.png" alt="" class="img1">
        <img src="./image/flower.png" alt="" class="img2">
        <?php
    if($insert){
      echo '<div class="alert alert-success alert-dismissible fade show al" role="alert">
        <strong>Success!</strong> Your note has been added successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }

    if($delete){
      echo '<div class="alert alert-success alert-dismissible fade show al" role="alert">
        <strong>Success!</strong> Your note has been deleted successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
  ?>
        <form action="work.php" method="POST" class="content">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Content</label>
                <div class="input-group">
                    <textarea class="form-control" id="content" name="content" required="required" rows="2"></textarea>
                    <button type="button" class="btn btn-light voice" id="contentVoiceButton"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-mic-fill" viewBox="0 0 16 16">
                            <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0V3z" />
                            <path
                                d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z" />
                        </svg></button>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg> Add note</button>
        </form>

        <button class="btn btn-light btn-sm shareButton" id="shareButton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
            <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
        </svg></button>

        <div class="container">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Content</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
          $sql = "SELECT * FROM `customlist` WHERE `name`='work' and `user`='$user' ORDER by `complete`";
          $result = mysqli_query($connection, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td class='fixed-len'>". $row['content'] . "</td>
            <td>";
                if($row['complete']==1)
                    echo '<input type="checkbox" checked class="mx-1 complete" name="complete" id=c'.$row['sno'].'>';
                else
                    echo '<input type="checkbox" class="mx-1 complete" name="complete" id=c'.$row['sno'].'>';
            
            echo "
             <button class='delete btn btn-sm btn-dark' id=".$row['sno']."><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3-fill' viewBox='0 0 16 16'>
            <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z'/></svg></button></td>
          </tr>";
            } 
          ?>
                </tbody>
            </table>
        </div>
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

    <script src="./JavaScript/custom.js"></script>

    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>

    <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log(e.target);
                sno = e.target.id;
                console.log(sno);
                if (confirm("Are you sure you want to delete this note!")) {
                    console.log("yes");
                    window.location = `work.php?delete=${sno}`;
                }
                else {
                    console.log("no");
                }
            })
        })
    </script>

    <script>
    completes = document.getElementsByClassName('complete');
    Array.from(completes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Complete ");
        sno = e.target.id.substr(1);
        console.log(sno);
        complete = sno;
        console.log(complete);
        window.location.href = 'work.php?complete=' + sno;
      })
    })
    </script>
</body>

</html>