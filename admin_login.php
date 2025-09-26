<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Admin Login</title>
</head>

<body>
    <?php require 'partials/index_nav.php';
    $showAlert=false;
    if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['login'])){
        include 'partials/db_conn.php';//database connection
        // $cpass=$_POST['cpassword'];
        $pass=$_POST['password'];
        $id=$_POST['id'];

        $tableName="admin_101";

        $q1="SELECT * FROM `admin_101` WHERE `admin_id`='$id'AND `password`='$pass';";
        $result=mysqli_query($conn,$q1);
        
        while($row=mysqli_fetch_assoc($result)){
            $name=$row['name'];
        }
        

        if(mysqli_num_rows($result) == 1){
            session_start();
            $_SESSION['name']= $name;
            $_SESSION['admin_id']=$id;
            $_SESSION['loggedin']=true;
            header("location:/admin_welcome.php");
        }
        else{
            $showAlert=true;
        }
        if($showAlert){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>Invalid Credentials !</strong><button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
        }
     }

     ?>
    <form action='/admin_login.php' method='post'>
        <div class="container col-md-6 my-4">
            <div class="card mt-5 bg-dark text-white">
                <h3 class="mt-2">
                    <center>ADMIN LOGIN<center>
                </h3>
                <div class="cardbody mx-4 my-4">
                    <div class="mb-3">
                        <label for="admin_id" class="form-label">ADMIN ID</label>
                        <input type="text" class="form-control" required id="admin_id" aria-describedby="emailHelp"
                            name="id">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" required id="password" name="password">
                    </div>
                    <!-- <div class="mb-3">
    <label for="cpassword" class="form-label">Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword">
    </div> -->
                    <center><button type="submit" name="login" class="btn btn-primary">Login</button></center>
                </div>
            </div>
        </div>
    </form>
    <?php
     
     
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>