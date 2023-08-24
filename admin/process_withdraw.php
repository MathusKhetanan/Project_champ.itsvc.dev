<?php
include('../config.php');

if (!empty($_GET) && isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === "update") {
  $withdraw_id = $conn->real_escape_string($_GET['id']);
  $sql = "UPDATE withdraw SET withdraw_status = 'successful' WHERE SUBSTRING(MD5(withdraw_id), 1, 8) = '$withdraw_id'";
  if ($conn->query($sql)) {
    echo "<script>
        alert('ยืนยันการได้รับเงินสำเร็จ');
        window.location.href = 'withdraw.php';
      </script>";
  } else {
    echo "<script>
        alert('ยืนยันการได้รับเงินไม่สำเร็จ');
        window.location.href = 'withdraw.php';
      </script>";
  }
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $admin_id = $_SESSION['admin_id'];
  $withdraw_money = $conn->real_escape_string($_POST['withdraw_money']);
  $withdraw_fee = (intval($withdraw_money) * 3) / 100;
  $withdraw_money = $withdraw_money - $withdraw_fee;
  $sql = "INSERT INTO withdraw(admin_id, withdraw_money, withdraw_fee) VALUE($admin_id, $withdraw_money, $withdraw_fee)";
  if ($conn->query($sql)) {
    echo "<script>
        alert('บันทึกข้อมูลการถอนเงินสำเร็จ');
        window.location.href = 'withdraw.php';
      </script>";
  } else {
    echo "<script>
        alert('บันทึกข้อมูลการถอนเงินไม่สำเร็จ');
        window.location.href = 'withdraw.php';
      </script>";
  }
  exit();
}
