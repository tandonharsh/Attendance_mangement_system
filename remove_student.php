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
    <title>Remove student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <?php
  require 'partials/user_nav.php';//navbar
// Database connection parameters
include 'partials/db_conn.php';
$count=1;
$tableName = $_SESSION['user_id']."_attendance";
if($_SERVER['REQUEST_METHOD']=='POST'&& isset($_POST['submit'])){
  $remove=$_POST['rm_student'];
  
  foreach ($remove as $key){
    // echo $key;
  $sql="DELETE FROM `$tableName` WHERE `$tableName`.`roll_num` = $key;";
  $result=mysqli_query($conn,$sql);
  while($count>0){
  if(($result)&&(isset($_POST['submit']))){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Data removed successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div> ";
  $count--;
  }
  else if(!$result && isset($_POST['submit'])){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Failed</strong> Data could not be removed due to some technical issue !
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div> ";
  $count--;
  }else{}
}
}
}
// Specify the table name
// $tableName = "$tableName";
$q1="SELECT * FROM `$tableName` ORDER BY  `roll_num` ASC";
$result_1=mysqli_query($conn,$q1);

if(mysqli_num_rows($result_1)>0){
  echo "<div class='container mt-5'>
  <div class='container mt-5'>
      <div class='row'>
          <div class='col'>
              <div class='card'>
              <h1><center class='mt-3'>REMOVE STUDENT<center></h1>
                  <div class='card-body mt-1'>
                  <form action='/remove_student.php' method='post'><div class='form-check'>
                      <table class='table table-striped table-hover table-dark table-bordered border-primary text-center' id='myTable'>
                          <tr>
                              <td>Roll no.</td>
                              <td>Name</td>
                              <td>Select for removing</td>
                          </tr>";
  while($row=mysqli_fetch_assoc($result_1)){
    // $roll=;
    echo"<tr>
  <td>".$row['roll_num']."</td>
  <td>".$row['name']."</td>
  <td>
  <input class='center-checkbox' type='checkbox' value='".$row['roll_num']."' name='rm_student[]'id='check_".$row['roll_num']."'onclick='enable()'>
  </div></td>
    </tr>";
  }
  ?>
  </table>
  <center><button disabled='true' type='submit' name='submit' id='btn' class='btn btn-primary'onclick='reload()'>Remove</button></center>
</form>
</div>
</div>
</div>
</div>
</div>
  <?php
}else{
  echo "<div class='container mt-5'><svg xmlns='http://www.w3.org/2000/svg' class='d-none'>
  <symbol id='exclamation-triangle-fill' viewBox='0 0 16 16'>
    <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
  </symbol>
</svg>
<div class='alert alert-danger d-flex align-items-center' role='alert'>
  <svg class='bi flex-shrink-0 me-2' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
  <div>
    <strong>ALREADY EMPTY !</strong>
  </div>
</div>
</div>";
}
mysqli_close($conn);
?>
<script>
  function enable(){
    const check=document.querySelectorAll('.center-checkbox');
    const btn=document.getElementById('btn');
    atLeastOneChecked='false';
    check.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                btn.disabled = !Array.from(check).some(checkbox => checkbox.checked);
            });
        });
  }
  function reload(){
    location.reload();
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
