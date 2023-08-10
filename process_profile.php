<?php 
  include('config.php');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_SESSION['user_id'];
    $user_fullname =  $conn->real_escape_string($_POST['user_fullname']);
    $user_password =  $conn->real_escape_string($_POST['user_password']);
    $user_password_confirm =  $conn->real_escape_string($_POST['user_password_confirm']);
    $user_address =  $conn->real_escape_string($_POST['user_address']);
    $user_tel =  $conn->real_escape_string($_POST['user_tel']);
    $user_pet = $conn->real_escape_string(implode(',',$_POST['user_pet']));
    $sql = "UPDATE user SET user_fullname = '$user_fullname', user_address = '$user_address', user_tel = '$user_tel'";
    if($user_password != "" && $user_password_confirm != "" && $user_password == $user_password_confirm){
      $sql .= ", user_password = MD5('$user_password')";
    }
    $sql .= ", user_pet = '$user_pet' WHERE user_id = $user_id";
    if($conn->query($sql)){
      $_SESSION['user_fullname'] = $conn->real_escape_string($_POST['user_fullname']);
      $_SESSION['user_address'] = $conn->real_escape_string($_POST['user_address']);
      $_SESSION['user_tel'] = $conn->real_escape_string($_POST['user_tel']);
      $_SESSION['user_pet'] = $conn->real_escape_string(implode(',',$_POST['user_pet']));
      echo "<script>
        alert('บันทึกข้อมูลสำเร็จ');
        window.location.href = 'profile.php';
      </script>";
    }else{
      echo "<script>
        alert('บันทึกข้อมูลไม่สำเร็จ');
        window.history.back();
      </script>";
    }
    exit();
  }
