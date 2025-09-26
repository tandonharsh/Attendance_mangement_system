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
  <title>Update Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php
  require 'partials/user_nav.php';
  include 'partials/db_conn.php';
//set timeZone
date_default_timezone_set("Asia/Calcutta");
?>
  <form action=/edit_attend.php method='post'>
    <div class="container ms-auto text-center">
      <div class="card mt-5 ">
      <div class="card-body">
      <div class="bg-dark text-white">
        <h1 class='pt-2'><center>UPDATE ATTENDANCE<center></h1>
          <div class="mb-2 text-center">
            <label for="date" class="form-label">Choose a date :</label>
            <input type="date" class="form-control-sm" id="date" name='date' max=<?php echo date('Y-m-d');?>>
          </div>
          <div class="mb-2">
            <center><button class="btn btn-primary mb-4" name="submit_dt" rows="3">Select Date</button></center>
          </div>
          </div>
        </div>
      </div>
    </div>
  </form>
  <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $date=date_create($_POST['date']);
      
      $column=date_format($date,"d/m/y");
     
      //table name
      $tableName = $_SESSION['user_id']."_attendance";
      // query to check if the column already exists or not
      $q1="SELECT * FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name = '$tableName' AND column_name = '$column'";
          $result_1=mysqli_query($conn,$q1);
         
      if($result_1->num_rows>0){
        
        //fetch data rows
        $q2 = "SELECT * FROM $tableName ORDER BY  `roll_num` ASC";
        $result_2= mysqli_query($conn,$q2);
        if($result_2->num_rows>0){
          ?>
  <form action=/update_attend.php method='post'>
    <div class="container mt-5">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <center>
                <h4>Date of the attendance which will be updated➡️
                  <?php echo$column;?>
                </h4>
              </center>
              <table class="table table-striped table-hover table-dark table-bordered border-primary text-center"
                id="myTable">
                <tr>
                  <td>Roll no.</td>
                  <td>Name</td>
                    <td><strong>Present</strong></td>
                   <td><strong>Absent</strong></td>
                </tr>
                <?php
                while($row=mysqli_fetch_assoc($result_2)){
                 $checkforPr=$row[$column]?"checked":"";
                 $checkforAb=$row[$column]?"":"checked";
                  echo "<tr>";
                  echo "<td>".$row['roll_num']."</td>";
                  echo "<td>".$row['name']."</td>";
                  echo "<td><label for='pr_".$row['roll_num']."'>Present </label> <input class='form-check-input' type='radio' name='attendance[".$row['roll_num']."]' required id='pr_".$row['roll_num']."'value='pr'".$checkforPr."></td>";
                  echo "<td><label for='ab_".$row['roll_num']."'>Absent </label> <input class='form-check-input' type='radio' name='attendance[".$row['roll_num']."]' required id='ab_".$row['roll_num']."'value='ab' ".$checkforAb."></td>";
                  echo "</tr>";
                }
                ?>
                <input type='hidden' value=<?php echo $column ?> name='hidden_dt'>
              </table>
              <center><button type="submit" class="btn btn-warning" name="submit"><strong>Update Attendance</strong></button></center>
            </form>
            </div>
            </div>
            </div>
            </div>
            </div>
          <?php
          }
            }
            else{
            ?>
            <script>
            alert('Attendance for this date does not exist 🙄!');
            </script>
            <?php
            }
        }
          

// }
// Close the connection
$conn->close();
?>
<script>
    // Check for the status query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
      // Display a success alert
      alert('Attendance updated successfully!😀👍');
    } else if (status === 'error') {
      // Display an error alert (optional)
      alert('oops! An error occured while updating the attendance😥');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>