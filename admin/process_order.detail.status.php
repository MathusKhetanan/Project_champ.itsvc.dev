<?php 
  include('../config.php');

  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_status']) && isset($_GET['id'])){
    
    $id = $_GET['id'];
    $change_status = $conn->real_escape_string($_POST['change_status']);

    $sql = "UPDATE orders SET order_status = '$change_status'";
    if(isset($_POST['order_tracking'])){
      $order_tracking = $conn->real_escape_string($_POST['order_tracking']);
      $sql .= ", order_tracking = '$order_tracking'";
    }
    $sql .= " WHERE order_id = ".$id;
    if($conn->query($sql)){
      echo "<script>
        alert('ปรับสถานะออเดอร์สำเร็จ');
        window.location.href = 'order.detail.php?id=$id';
      </script>";
    }else{
      echo "<script>
        alert('ปรับสถานะออเดอร์ไม่สำเร็จ');
        window.location.href = 'order.detail.php?id=$id';
      </script>";
    }
    exit();
  }
?>