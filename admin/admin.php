<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$sql = "SELECT * FROM admin";
$result = $conn->query($sql);
?>

<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการแอดมิน</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    จัดการแอดมิน
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->

  <!-- begin panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">จัดการแอดมิน</h4>
      <div class="btn-group">
        <a href="admin_add.php" class="btn btn-success btn-xs">เพิ่มข้อมูลแอดมิน</a>
      </div>
    </div>
    <div class="panel-body" style="overflow-y: scroll;">
      <table id="data-table-default" class="table table-bordered">
        <thead>
          <tr>
          <th class="text-nowrap">ลําดับ</th>
            <th class="text-nowrap">ชื่อบัญชีผู้ขาย</th>
            <th width="15rem" class="text-nowrap">อีเมล</th>
            <th class="text-nowrap">ชื่อ-นามสกลุผู้ขาย</th>
            <th class="text-nowrap">เบอร์ติดต่อ</th>
            <th class="text-nowrap text-center">ชื่อธนคาร</th>
            <th class="text-nowrap text-center">เลขที่บัญชี</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row) { ?>
            <tr>
              <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
              <td><?php echo $row['admin_username']; ?></td>
              <td><?php echo $row['admin_email']; ?></td>
              <td><?php echo $row['admin_username']; ?></td>
              <td><?php echo $row['admin_tel']; ?></td>
              <td><?php echo $row['admin_bank_name']; ?></td>
              <td><?php echo $row['admin_account_number']; ?></td>
          </tr>
            </tr>
            
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- end panel -->

</div>
<!-- end #content -->

<script>
  function confirmDelete(adminId) {
    Swal.fire({
      title: "ยืนยันการลบข้อมูล",
      text: "คุณต้องการลบข้อมูลแอดมินนี้หรือไม่?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = `process_admin.delete.php?id=${adminId}&action=delete`;
      }
    });
  }
</script>

<?php include('includes/footer.php'); ?>