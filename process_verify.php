<?php 
  include('config.php');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    try {
      $user_username =  $conn->real_escape_string($_POST['user_username']);
      $user_password =  $conn->real_escape_string($_POST['user_password']);
      $user_address =  $conn->real_escape_string($_POST['user_address']);
      $user_tel =  $conn->real_escape_string($_POST['user_tel']);
      $user_pet = $conn->real_escape_string(implode(',',$_POST['user_pet']));
      $sql = "UPDATE user SET user_username = '$user_username', user_password = MD5('$user_password'), user_address = '$user_address', user_tel = '$user_tel', user_pet = '$user_pet', user_status = 1, token = NULL WHERE user_id = (SELECT user_id FROM user WHERE token = '".$_GET['token']."')";
      if($conn->query($sql)){
        echo "<script>
          alert('บันทึกข้อมูลสำเร็จ');
          window.location.href = 'login.php';
        </script>";
      }
    } catch (\Throwable $th) {
      echo "<script>
        alert('อาจมีชื่อบัญชีนี้ในระบบแล้ว บันทึกข้อมูลไม่สำเร็จ');
        window.history.back();
      </script>";
    }
  }
?>
