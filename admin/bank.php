<?php
// Include necessary files
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

// Use prepared statement to prevent SQL injection
$sql = "SELECT * FROM tbl_bank";
$result = $conn->query($sql);
?>
<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการบัญชีธนาคาร</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    จัดการบัญชีธนาคาร
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->
  <!-- begin panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">จัดการบัญชีธนาคาร</h4>
    </div>
    <div class="panel-body" style="overflow-y: scroll;">
      <table id="data-table-default" class="table table-bordered">
        <thead>
          <tr>

            <th class="text-nowrap text-center">ลําดับ</th>
            <th class="text-nowrap text-center">ชื่อธนคาร</th>
            <th class="text-nowrap text-center">เลขที่บัญชีธนาคาร</th>
            <th class="text-nowrap text-center">ประเภทธนคาร</th>
            <th class="text-nowrap text-center">ชื่อ-นามสกุล</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row) { ?>
            <tr>
              <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
              <td><?php echo $row['b_name']; ?></td>
              <td><?php echo $row['b_number']; ?></td>
              <td><?php echo $row['b_type']; ?></td>
              <td>
                <div class="ellipsis-3" style="width: rem;"><?php echo $row['b_owner']; ?></div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <?php include('includes/footer.php'); ?>