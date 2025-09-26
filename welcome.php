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
    <title><?php echo "Welcome ". $_SESSION['name'] ; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 
  <?php 
  include 'partials/user_nav.php';
  include 'partials/db_conn.php';
 echo "<div class='contaniner mt-5 mx-4 text-center'><div class='alert alert-info' role='alert'>
  <h2 class='alert-heading'>Welcome ".$_SESSION['name']."</h2><bold><h1>🤗😀</h1></bold>
  <hr>
</div></div>";
date_default_timezone_set('Asia/kolkata');
  $table_name=$_SESSION['user_id']."_attendance";//table name
  $column=date('d/m/y');// column name
  //check for the column existance
  $q1="SELECT * FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name = '$table_name' AND column_name = '$column'";
  $result_1=mysqli_query($conn,$q1);

  if($result_1->num_rows>0){
  $q2="SELECT * FROM $table_name" ; 
  $result_2=mysqli_query($conn,$q2);
  $pr=0;
  $ab=0;
  while($row=mysqli_fetch_assoc($result_2)){
    ($row[$column]=='1')?$pr++:$ab++;
  }
              echo "<center><div class='container mt-5'>
                <div class='card p-4  bg-warning text-dark' style='width: 18rem;'>
                <div class='card-header bg-warning text-dark'>
                  <h4>Today's Strength</h4>
                </div>
                <ul class='list-group list-group-flush  bg-dark text-white'>
                  <li class='list-group-item  bg-dark text-white'><h5>Total Present ➡️ ".$pr."</h5></li>
                  <li class='list-group-item  bg-dark text-white'><h5>Total Absent ➡️ ".$ab."</h5></li>
                  <li class='list-group-item  bg-dark text-white'><h5>Total Strength ➡️ ".$pr+$ab."</h5></li>
                </ul>
              </div>
                </div></center>";
  }
  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
