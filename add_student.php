<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location:/index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <?php
  require 'partials/user_nav.php';//navbar
 // Database connection parameters
 include 'partials/db_conn.php';
// Specify the table name
$tableName = $_SESSION['user_id']."_attendance";
if($_SERVER['REQUEST_METHOD']=='POST'&& isset($_POST['submit'])){
  $roll_num=$_POST['roll'];
  $name=$_POST['name'];

  // echo $roll_num."<br>";
  // echo $name;

  $sql="INSERT INTO `$tableName` (roll_num,name) VALUES ('$roll_num','$name');";
  $result=mysqli_query($conn,$sql);
  
  if($result && isset($_POST['submit'])){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Data insertion successful
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div> ";
  }
  else if(!$result && isset($_POST['submit'])){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Failure!</strong> Data could not be inserted due to some technical issue or check you entered a unique roll number or not !
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div> ";
  }else{}
}
?>
<form action="/add_student.php" method="post">
  <div class="container  ms-auto ">
    <div class="card  mt-5">
    <div class="card-body">
      <div class="bg-dark text-white">
    <h1 class="pt-2"><center>ADD STUDENT<center></h1>
  <div class="mb-3 mx-5 mt-2">
    <label for="roll" class="form-label"><h4>Roll Number</h4></label>
    <input type="number" class="form-control" name="roll" id="roll" aria-describedby="emailHelp"required >
  </div>
  <div class="mb-3 mx-5 ">
    <label for="name" class="form-label"><h4>Name</h4></label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <center><button type="submit" name="submit" class="btn btn-primary mb-3">Add Student</button></center>
  </div>
  </div>
  </div>
  </div>
  </form>
<?php
$q1="SELECT * FROM `$tableName` ORDER BY  `roll_num` ASC";
$result_1=mysqli_query($conn,$q1);

if(mysqli_num_rows($result_1)>0){
  echo "<div class='container mt-5'>
  <div class='container mt-5'>
      <div class='row'>
          <div class='col'>
              <div class='card'>
                  <div class='card-body'>
                      <table class='table table-striped table-hover table-dark table-bordered border-primary text-center' id='myTable'>
                          <tr>
                              <td>Roll no.</td>
                              <td>Name</td>
                          </tr>";
  while($row=mysqli_fetch_assoc($result_1)){
    echo"<tr>
  <td>".$row['roll_num']."</td>
  <td>".$row['name']."</td>
  </tr>";
  }
  ?>
  </table>
</div>
</div>
</div>
</div>
</div>
  <?php
}
mysqli_close($conn);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
