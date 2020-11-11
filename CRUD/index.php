<?php

$insert = false;
$update = false;
$delete = false;
#Create a variable for connection
$serverName = "localhost";
$userName = "root";
$pass = "";
$database = "notes";

#create connection
$conn = mysqli_connect($serverName, $userName, $pass, $database);

#check conn
if(!$conn){
    die("Connection Falied:".mysqli_connect_error());
}
if(isset($_GET['delete'])){
    $getDElId = $_GET['delete'];
    #create sql
    $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $getDElId";

    $result = mysqli_query($conn, $sql);

    if($result){
        $delete = true;
    }
}
if($_SERVER['REQUEST_METHOD']== 'POST'){
    if(isset($_POST['getSno'])){
        #update task
        $task = $_POST['editedTask'];
        $sno = $_POST['getSno'];
        $date = date('Y-m-d');
        date_default_timezone_set('Asia/Kolkata');
        $time = date(' H:i:s');
        #create sql
        $sql = "UPDATE `notes` SET `title` = '$task', `date` = '$date', `time` = '$time' WHERE `notes`.`sno` = $sno";

        $result = mysqli_query($conn, $sql);
        if($result){
            $update = true;
        }
        else{
            echo"Error:". mysqli_error($result);
        }
    }
    else{
        $task = $_POST['task'];
        
        #Create sql
        $sql = "INSERT INTO `notes`(`title`) VALUES('$task')";

        $result = mysqli_query($conn, $sql);

        if($result){
            $insert = true;
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    
    <title>To-Do List</title>
    <style>
    tr:nth-child(2n){
        color: black;
    }
    tr:nth-child(2n) .fa{
        color:black;
    }
    tr:nth-child(2n) .fa:hover{
        color:#0275d8;
    }
    .fa {
        color: white;
        cursor: pointer;
        font-size: 1.5em;
    }

    .fa:hover {
        color: #0275d8;
    }
    </style>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/PHP/CRUD/" method="post">
                        <input type="hidden" name="getSno" id="getSno">
                        <div class="form-group">
                            <label for="task">Task</label>
                            <input type="text" class="form-control" id="editedTask" name="editedTask"
                                aria-describedby="emailHelp" placeholder="Enter your task" Required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Nav-Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">CRUD</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Successfully inserted your task.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
    if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Successfully updated your task.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
    if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Successfully deleted your task.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
    }
    ?>
    <div class="container my-4">
        <h2>To-Do List</h2>
        <form action="/PHP/CRUD/" method="post">
            <div class="form-group">
                <label for="task">Task</label>
                <input type="text" class="form-control" id="task" name="task" aria-describedby="emailHelp"
                    placeholder="Enter your task" Required>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
    </div>
    <div class="container">
        <table class="table table-striped table-dark" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">Task</th>
                    <th scope="col">Time</th>
                    <th scope="col">Date</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
      #create sql
      $sql = "SELECT * FROM `notes`";
      $result = mysqli_query($conn, $sql);
      $sno = 0;
      while($rows = mysqli_fetch_assoc($result)){
          $sno = $sno + 1;
          echo "<tr>
          <th scope='row'>". $sno. "</th>
      <td>". $rows['title']. "</td>
      <td>". $rows['time']. "</td>
      <td>". $rows['date']. "</td>
      <td><i class='edit fa fa-pencil-square-o' id=".$rows['sno']." aria-hidden='true'></i></></td>
    <td><i class='del fa fa-trash-o' id=". $rows['sno']. " aria-hidden='true'></i></></td>   
    </tr>";
      }
      ?>
            </tbody>
        </table>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>
    <script>
    // for edit
    Array.from(document.getElementsByClassName('edit')).forEach((element) => {
        element.addEventListener("click", (e) => {
            //console.log(e.target)
            tr = e.target.parentNode.parentNode;
            val = tr.getElementsByTagName("td")[0].innerText;
            getSno.value = e.target.id;
            editedTask.value = val;
            $('#Modal').modal('toggle')
        })
    })

    // for delete
    Array.from(document.getElementsByClassName('del')).forEach((element) => {
        element.addEventListener("click", (e) => {
            //console.log(e.target)
            tr = e.target.parentNode.parentNode;
            val = tr.getElementsByTagName("td")[0].innerText;

            // confermation box
            if (confirm("Are you sure?")) {
                getDelId = e.target.id;
                console.log(getDelId)
                window.location = `/PHP/CRUD/index.php?delete=${getDelId}`;
            }
        })
    })
    </script>
</body>

</html>