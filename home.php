<?php

    $insert=false;
    $delete=false;
    $update=false;

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
      $sql = "DELETE FROM `list` WHERE `sno` = $sno";
      $result = mysqli_query($connection, $sql);
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['snoEdit'])){
        //update the record
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $content =$_POST["contentEdit"];

        $sql = "UPDATE `list` SET `title`= '$title' , `content` =  '$content' WHERE `list`.`sno`=$sno";

        $result = mysqli_query($connection, $sql);

        if($result){
          $update = true;
        }
        else{
          echo "The record was not updated successfully because of this error ---> ". mysqli_error($connection);
        } 
      }
      else{
        $title = $_POST["title"];
        $content =$_POST["content"];

        $sql = "INSERT INTO `list` (`user`, `title`, `content`) VALUES ('$user', '$title', '$content')";

        $result = mysqli_query($connection, $sql);
   
        if($result){ 
            $insert = true;
        }
        else{
            echo "The record was not inserted successfully because of this error ---> ". mysqli_error($connection);
        } 
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

  <link rel="stylesheet" href="./css/home.css">

</head>

<body>

  <div class="logout">
    <a href="index.php" type="button" class="btn btn-light btn-sm">
      <img width="25" height="25" src="./image/turn-off.png" alt="">
      </a>
  </div>

  <h1>
    <center>To-Do-List</center>
  </h1>

  <div class="bg-flower">
    <img class="img1" src="./image/flower.png" alt="">
    <img class="img2" src="./image/flower.png" alt="">
  </div>

  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="home.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="contentEdit" name="contentEdit" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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

    if($update){
      echo '<div class="alert alert-success alert-dismissible fade show al" role="alert">
        <strong>Success!</strong> Your note has been updated successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
  ?>

  <div class="container mb-3 form">
    <form action="home.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Title of your note</label>
        <input type="text" class="form-control" id="title" name="title" required="required"
          aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" required="required" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-light"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
          fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
          <path
            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg> Add note</button>
    </form>
  </div>

  <h4>
    <center>Customize these Templates</center>
  </h4>
  <div class="container my-4 template">
    <div class="row">
      <a class="col-sm-4 mb-3 mb-sm-0" href="kitchen.php">
        <div class="card text-center">
          <div class="card-body template-items">
            <div class="template-image">
              <img src="./image/kitchen.png" />
            </div>
            <h5 class="card-title">Kitchen</h5>
          </div>
        </div>
      </a>
      <a class="col-sm-4 mb-3 mb-sm-0" href="study.php">
        <div class="card text-center">
          <div class="card-body template-items">
            <div class="template-image">
              <img src="./image/study.png" />
            </div>
            <h5 class="card-title">Study</h5>
          </div>
        </div>
      </a>
      <a class="col-sm-4 mb-3 mb-sm-0" href="work.php">
        <div class="card text-center">
          <div class="card-body template-items">
            <div class="template-image">
              <img src="./image/work.png" />
            </div>
            <h5 class="card-title">Work</h5>
          </div>
        </div>
      </a>
    </div>
    <hr>
  </div>

  <div class="container">
    <h4>
      <center>Your Custom To-Do-Lists</center>
    </h4>
    <div class="card text-center lists" id="myTable">
      <?php
        $sql = "SELECT * FROM `list` WHERE `user`='$user'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result)==0)
            echo '<p>You do not have any custom templates</p>';
        $sno=0;
        while($row = mysqli_fetch_assoc($result)){
          $sno++;
          echo '
          <div class="card-body items">
            <h5 style="display:inline;" class="card-title">'.$sno.') '.'</h5><h5 class="card-title" style="display:inline;">'.$row['title'].'</h5>
            <p class="card-text">'. $row['content'].'</p>

            <a class="btn btn-info btn-sm edit" id='.$row['sno'].'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg> 
            Edit</a>

            <a class="btn btn-info btn-sm delete" id=d'.$row['sno'].'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg> 
            Delete</a>
            <div class="invisible">hello</div>
            <div class="card-footer text-body-secondary">'. $row['tsStamp'].'</div>
          </div>
          ';
        }
      ?>
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

  <script>
    edits = document.getElementsByClassName('edit'); //fetching the edit button
    Array.from(edits).forEach((element) => { //for every edit button
      element.addEventListener("click", (e) => { //onClick
        console.log("Edit ", e.target.parentNode);
        div = e.target.parentNode; //to fetch the title and description from parent elements of edit button
        title = div.getElementsByTagName("h5")[1].innerText;
        content = div.getElementsByTagName("p")[0].innerText;
        sno = e.target.id;
        console.log(title, content, sno);
        //to show it on modal--->
        titleEdit.value = title;
        contentEdit.value = content;
        snoEdit.value = sno;
        console.log(titleEdit, contentEdit, snoEdit);
        $('#editModal').modal('toggle'); //to open the modal
      })
    })
  </script>

  <script>
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Delete ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `home.php?delete=${sno}`;
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>