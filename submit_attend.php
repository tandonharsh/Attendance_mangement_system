<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location:/index.php");
  exit;
}
$tableName=$_SESSION['user_id']."_attendance";
include 'partials/db_conn.php';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
              $col=$_POST['hidden_dt'];//date seleted for marking the attendance
              $q3="ALTER TABLE `$tableName` ADD `$col` TINYINT(1) NOT NULL  DEFAULT FALSE ;";//for addind a new column
              $result_3= mysqli_query($conn,$q3);
              $roll=$_POST['attendance'];//roll no. of each student
              foreach($roll as $roll_num => $status){
                // echo "Roll Number: $roll_num, Status: $status<br>";
                $status_val=($status =='pr')?1:0;
                $q4 = "UPDATE `$tableName` SET `$col` = $status_val WHERE `roll_num` = $roll_num;";
                
                // if($status =='pr'){
                // $q4 = "UPDATE `student_info` SET `$col` = 1 WHERE `roll_num` = $roll_num;";
                // // $q4="UPDATE `student_info` SET `$col`= `1` WHERE `$roll_num`;";
                // }else{
                // $q4="UPDATE `student_info` SET `$col`= 0 WHERE `roll_num` = $roll_num ;";
                // }
                $result_4=mysqli_query($conn,$q4);
                if($result_4 === TRUE){
                    $success= true;
                  }
                  else{
                    $success=false;
                  }
              }
              if($success){
              header("location:/take_attend.php?status=success");
              }else{
                header("location:/take_attend.php?status=error");
              }
            }
            ?>