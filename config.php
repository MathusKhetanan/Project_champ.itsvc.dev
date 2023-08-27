<?php
  if(!isset($_SESSION)){
    session_start();
  }
// การเชื่อมฐานข้อมูล
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "champ";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn -> set_charset("utf8");
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SET sql_mode = '';";
  $conn->query($sql);
 
  
  $Status = array(
    'paid' => 'ชำระเงินแล้ว',
    'preparing' => 'กำลังเตรียมจัดส่งสินค้า',
    'shipping' => 'กำลังจัดส่งออเดอร์',
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



  