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
    <title>Get Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <?php
  require 'partials/user_nav.php';
  ?>
  <div class="container ms-auto text-center" >
  <div class="card mt-5">
    <div class="card-body">
  <div class="bg-dark text-white">
  <h1><center>GET ATTENDANCE<center></h1>
  <form action="/get_attend.php"  method='post'>
    <label for="month"class='px-3'>Select a month for which attendance is needed :</label> <select id="month" name="month" class="mt-4">
  <option name="" value="" style="display:none;">Select month</option>
  <option value="01" >January</option>
  <option value="02" >February</option>
  <option value="03" >March</option>
  <option value="04" >April</option>
  <option value="05" >May</option>
  <option value="06" >June</option>
  <option value="07" >July</option>
  <option value="08" >August</option>
  <option value="09" >September</option>
  <option value="10" >October</option>
  <option value="11" >November</option>
  <option value="12" >December</option>
</select>
<br><br>
<button class='btn btn-primary mb-4' type="submit" name="submit">SHOW</button>
<br>
</form>
</div>
</div>
</div>
</div>
  <?php
   
   include 'partials/db_conn.php';
// Specify the table name
$tableName = $_SESSION['user_id']."_attendance";

// Execute the SHOW COLUMNS query
$sql = "SHOW COLUMNS FROM $tableName";
$result = $conn->query($sql);

if($_SERVER['REQUEST_METHOD']=='POST'){
  $mon=$_POST['month'];
 
if ($result->num_rows > 0) {
  ?>
  <div class="container mt-5">
  <center><h2><?php 
$info = date("F", mktime(0,0,0,$mon));
echo "Month ➡️ ".$info;
?></h2></center>
      <div class="row">
          <div class="col">
              <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-dark table-bordered border-primary text-center " id="myTable">
                          <tr>
                              <td>Roll no.</td>
                              <td>Name</td>                                                     
  <?php
  $columnName=[];
  $counter=0;
  $colName=[];
    // Fetch and print column names one by one
    while ($col = $result->fetch_assoc()) {
      
      if($counter++>1){
        $date=$col['Field'];
        $dateTime=DateTime::createFromFormat('d/m/y',$date);
        $month=$dateTime->format('m');
        // echo $date."<br>";
      
        if( $mon==$month ){
          $columnName[]=$date;
        //   echo"<td>".$date."</td>";
        }

        if($mon>$month){
          $colName[]=$date;
        }
    }
  } 
  sort($columnName);
    foreach($columnName as $date){
        echo"<td>".$date."</td>";
    }

    echo "<td>Total Present</td>";
    echo "<td>Total Absent</td>";
    echo "<td>Last Total</td>";
    echo "<td>Total Carry Forward</td>";
    echo "</tr>";
} else {
    echo "0 results";
}

// fetch the data rows
$q1="SELECT * FROM `$tableName` ORDER BY  `roll_num` ASC";
$result_1=mysqli_query($conn,$q1);

if($result_1->num_rows>0){
  $col_pr=0;
  $col_ab=0;
  $col_lt=0;
  $col_tcf=0;
while($row =mysqli_fetch_assoc($result_1)){
          
  echo"<tr>
  <td>".$row['roll_num']."</td>
  <td>".$row['name']."</td>";
  $pr=0;
  $ab=0;
  $last_total=0;
  $total_cf=0;
  
foreach($columnName as $key){
  $pr+=$row[$key];
  $ab++;
  echo "<td>".$row[$key]."</td>";
}
foreach($colName as $key_1){
  $last_total+=$row[$key_1];
}
$ab-=$pr;
$total_cf=$pr+$last_total;
echo "<td>".$pr."</td>";
echo "<td>".$ab."</td>";
echo "<td>".$last_total."</td>";
echo "<td>".$total_cf."</td>";
echo "</tr>";
$col_pr+=$pr;
$col_ab+=$ab;
$col_lt+=$last_total;
$col_tcf+=$total_cf;
}
$counter=0;
echo "<tr>
<td>-</td>
<td>-</td>";
$sql = "SHOW COLUMNS FROM $tableName";
$result = $conn->query($sql);
while ($col = $result->fetch_assoc()) {
  if($counter++>1){
    $date=$col['Field'];
    $dateTime=DateTime::createFromFormat('d/m/y',$date);
    $month=$dateTime->format('m');


    if( $mon==$month ){
      $q2 = "SELECT * FROM `$tableName` ORDER BY  `roll_num` ASC";
              $result_2= mysqli_query($conn,$q2);
              $pr=0;
              $ab=0;
              while($row=mysqli_fetch_assoc($result_2)){
                  if($row[$date]=='1'){
                    $pr++;
                  }
              }
              echo"<td>".$pr."</td>";
    }
}
} 
echo"
<td>".$col_pr."</td>
<td>".$col_ab."</td>
<td>".$col_lt."</td>
<td>".$col_tcf."</td>
</tr>";
}
?>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  
<?php
}
// Close the connection
$conn->close();
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
