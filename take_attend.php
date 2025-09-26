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
  <title>Mark Attendance</title>
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
  <form action=/take_attend.php method='post'>
    <div class="container ms-auto text-center ">
      <div class="card mt-5 ">
        <div class="card-body">
        <div class="bg-dark text-white">
        <h1><center>MARK ATTENDANCE<center></h1>
          <div class="mb-2 text-center">
            <label for="date" class="form-label">Choose a date :</label>
            <input type="date" class="form-control-sm" id="date" name='date' max=<?php echo date('Y-m-d');?>>
          </div>
          <div class="pb-3">
            <center><button class="btn btn-primary" name="submit_dt" rows="3">Select Date</button></center>
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
      
      $id=$_SESSION['user_id'];
      //table name
      $tableName =$id."_attendance";
      // query to check if the column already exists or not
      $q1="SELECT * FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name = '$tableName' AND column_name = '$column'";
          $result_1=mysqli_query($conn,$q1);
      if($result_1->num_rows==0){
        
        //fetch data rows
        $q2 = "SELECT * FROM $tableName ORDER BY  `roll_num` ASC";
        $result_2= mysqli_query($conn,$q2);
        if($result_2->num_rows>0){
          ?>
  <form action=/submit_attend.php method='post'>
    <div class="container mt-5">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <center>
                <h4>Date of Attendance➡️
                  <?php echo$column;?>
                </h4>
              </center>
              <table class="table table-striped table-hover table-dark table-bordered border-primary text-center"
                id="myTable">
                <tr>
                  <td>Roll no.</td>
                  <td>Name</td>
                  <td><label for='all_pr'><strong>All Present</strong></label> <input class='form-check-input'
                      type='radio' id='all_pr' name='attendance' value='pr' onchange="selectAll('pr')"></td>
                  <td><label for='all_ab'><strong>All Absent</strong></label> <input class='form-check-input'
                      type='radio' id='all_ab' name='attendance' value='ab' onchange="selectAll('ab')"></td>
                </tr>
                <?php
                while($row=mysqli_fetch_assoc($result_2)){
                  echo "<tr>";
                  echo "<td>".$row['roll_num']."</td>";
                  echo "<td>".$row['name']."</td>";
                  echo "<td><label for='pr_".$row['roll_num']."'>Present </label> <input class='form-check-input' type='radio' name='attendance[".$row['roll_num']."]' required id='pr_".$row['roll_num']."'value='pr'></td>";
                  echo "<td><label for='ab_".$row['roll_num']."'>Absent </label> <input class='form-check-input' type='radio' name='attendance[".$row['roll_num']."]' required id='ab_".$row['roll_num']."'value='ab'></td>";
                  echo "</tr>";
                }
                ?>
                <input type='hidden' value=<?php echo $column ?> name='hidden_dt'>
              </table>
              <center><button type="submit" class="btn btn-warning" name="submit"><strong>Mark Attendance</strong></button></center>
  </form>
  </div>
  </div>
  </div>
  </div>
  </div>
  <script>
    function selectAll(value) {
      const radios = document.querySelectorAll('input[type="radio"][value="' + value + '"]');
      radios.forEach(radio => {
        radio.checked = true;
      });
    }
  </script>
          <?php
          }
            }
            else if($column==date('d/m/y')){
              $q2 = "SELECT * FROM $tableName ORDER BY  `roll_num` ASC";
              $result_2= mysqli_query($conn,$q2);
              $pr=0;
              $ab=0;
              while($row=mysqli_fetch_assoc($result_2)){
                  ($row[$column]=='1')?$pr++:$ab++;
                  // echo $row[$column]."<br>";
              }
              echo "<center><h3>Today's attendance has already been marked</h3></center>";
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
            else{
              echo "<center><h3>It seems that attendance for ".$column." has already been marked</h3></center>";
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
      alert('Attendance submitted successfully!😀👍');
    } else if (status === 'error') {
      // Display an error alert (optional)
      alert('oops! An error occured while submitting the attendance😥');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>