<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการสมาชิก</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    จัดการร้านค้า
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->

  <!-- begin panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">จัดการร้านค้า</h4>
    </div>
    <div class="panel-body" style="overflow-y: scroll;">
      <table id="data-table-default" class="table table-bordered">
        <thead>
          <tr>
            <th width="1%"></th>
            <th class="text-nowrap">ชื่อ-สกุล</th>
            <th class="text-nowrap">ชื่อบัญชีผู้ใช้</th>
            <th width="15rem" class="text-nowrap">ที่อยู่</th>
            <th class="text-nowrap">เบอร์ติดต่อ</th>
            <th class="text-nowrap">อัพเดทล่าสุด</th>
            <th class="text-nowrap text-center">สถานะ</th>
            <th class="text-nowrap text-center">ตัวเลือก</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row) { ?>
            <tr>
              <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
              <td><?php echo $row['user_fullname']; ?></td>
              <td><?php echo $row['user_username']; ?></td>
              <td>
                <div class="ellipsis-3" style="width: 15rem;"><?php echo $row['user_address']; ?></div>
              </td>
              <td><?php echo $row['user_tel']; ?></td>
              <td><?php echo $row['updatedAt']; ?></td>
              <td class="text-center">
                <form action="process_user.status.php" method="POST"><button type="submit" class="btn btn-<?php echo ($row['user_username'] === NULL) ? "warning" : (((bool)$row['user_status']) ? "success" : "danger"); ?>" name="change_status" value="<?php echo $row['user_id']; ?>" <?php echo ($row['user_username'] === NULL) ? "disabled" : ""; ?>><?php echo ($row['user_username'] === NULL) ? "ยังไม่ยืนยันตัวตน" : (((bool)$row['user_status']) ? "เปิดใช้งาน" : "ปิดใช้งาน"); ?></button></form>
              </td>
              <td class="text-center">
                <a class="btn btn-danger" onclick="if(confirm('คุณต้องการลบข้อมูลสมาชิกนี้หรือไม่?')){ location.href = 'process_user.delete.php?id=<?php echo $row['user_id']; ?>&action=delete' };">ลบ</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- end panel -->

</div>
<!-- end #content -->

<?php include('includes/footer.php'); ?>