<?php
  if(!isset($_SESSION)){
    session_start();
  }
// การเชื่อมฐานข้อมูล
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "project";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn -> set_charset("utf8");
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE `withdraw` SET `withdraw_status` = 'successful' WHERE withdraw_status = 'wait_confirm' AND DATE(updatedAt+ INTERVAL 10 DAY) <= DATE(NOW())";
  $conn->query($sql);
  
  $Status = array(
    'paid' => 'ชำระเงินแล้ว',
    'preparing' => 'กำลังเตรียมจัดส่งสินค้า',
    'shipping' => 'กำลังจัดส่งพัสดุ',
    'successful' => 'จัดส่งสำเร็จ',
    'canceled' => 'ถูกยกเลิก',
    'failed' => 'เกิดข้อผิดพลาด'
  );
  $StatusColor = array(
    'paid' => 'lime',
    'preparing' => 'yellow',
    'shipping' => 'purple',
    'successful' => 'success',
    'canceled' => 'gray',
    'failed' => 'danger'
  );

  $StatusWithdraw = array(
    'pending' => 'กำลังรอถอนเงิน',
    'successful' => 'ถอนเงินสำเร็จ',
    'wait_confirm' => 'รอผู้ขายยืนยัน',
    'canceled' => 'ถูกยกเลิก'
  );
  $StatusWithdrawColor = array(
    'pending' => 'warning',
    'successful' => 'success',
    'wait_confirm' => 'yellow',
    'canceled' => 'gray'
  );