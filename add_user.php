<?php
session_start();
if(!isset($_SESSION['admin_id']) || $_SESSION['admin_id']!=true){
    header("location:/index.php");
}
?>
<?php require 'partials/admin_nav.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Add User</title>
</head>
<body>
<form action='/add_user.php' method='post'>
    <div class="container col-md-6 my-4">
        <div class="card mt-5 bg-dark text-white">
        <h3 class="mt-2"><center>ADD USER<center></h3>
            <div class="cardbody mx-4 my-4">
    <div class="mb-3">
    <label for="user_id" class="form-label">USER ID</label>
    <input type="text" class="form-control" required id="user_id" aria-describedby="emailHelp" name="id">
    <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
    </div>
    <div class="mb-3">
    <label for="password" class="form-label">PASSWORD</label>
    <input type="password" class="form-control" required id="password" name="pass">
    </div>
    <div class="mb-3">
    <label for="cpassword" class="form-label">CONFIRM PASSWORD</label>
    <input type="password" class="form-control" required id="cpassword" name="cpass">
    <div class="form-text text-white">Make sure you enter the same password.</div>
    </div>
    <div class="mb-3">
    <label for="name" class="form-label">NAME</label>
    <input type="text" class="form-control" required id="name" name="name">
    </div>
    <center><button type="submit" name="submit"class="btn btn-primary">ADD</button></center>
    </div>
    </div>
    </div>
    </form>
    <?php
    // include 'partials/db_conn.php';
    if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['submit'])){
        include 'partials/db_conn.php';//database connection
        $id=$_POST['id'];
        $pass=$_POST['pass'];
        $cpass=$_POST['cpass'];
        $name=$_POST['name'];

        $tableName=$id."_attendance";

        if($pass==$cpass){
        $sql="INSERT INTO `user_101` VALUES ('$id', '$pass', '$name');";
        $result=mysqli_query($conn,$sql);
        $sql_2="CREATE TABLE `$tableName`(roll_num int(2) unique,name varchar(25));";
        $result_2=mysqli_query($conn,$sql_2);
        }else{
            echo "Passwords do not match";
        }
    }
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>