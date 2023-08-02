<?php 
  include('../config.php');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $seller_id = $_SESSION['seller_id'];
    $seller_shop = $conn->real_escape_string($_POST['seller_shop']);
    $seller_detail = $conn->real_escape_string($_POST['seller_detail']);
    $seller_address = $conn->real_escape_string($_POST['seller_address']);

    $sql = "UPDATE seller SET seller_shop = '$seller_shop', seller_detail = '$seller_detail' , seller_address = '$seller_address' WHERE seller_id = ".$seller_id;
    if($conn->query($sql)){
      $_SESSION['seller_shop'] = $conn->real_escape_string($_POST['seller_shop']);
      $_SESSION['seller_detail'] = $conn->real_escape_string($_POST['seller_detail']);
      $_SESSION['seller_address'] = $conn->real_escape_string($_POST['seller_address']);
      echo "<script>
        alert('แก้ไขข้อมูลร้านสำเร็จ');
        window.location.href = 'profile.php';
      </script>";
    }else{
      echo "<script>
        alert('แก้ไขข้อมูลร้านไม่สำเร็จ');
        window.location.href = 'profile.php';
      </script>";
    }
    exit();
  }
?>