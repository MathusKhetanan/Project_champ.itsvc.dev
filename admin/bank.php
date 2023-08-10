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
      <div class="btn-group">
        <a href="product.add.php" class="btn btn-success btn-xs">เพิ่มข้อมูลบัญชีธนาคาร</a>
      </div>
    </div>
    <div class="panel-body" style="overflow-y: scroll;">
      <table id="data-table-default" class="table table-bordered">
        <thead>
          <tr>
            <th width="ลําดับ"></th>
            <th class="text-nowrap">ชื่อธนคาร</th>
            <th class="text-nowrap">เลขที่บัญชีธนาคาร</th>
            <th class="text-nowrap">ประเภทธนคาร</th>
            <th class="text-nowrap">ชื่อ-นามสกุล</th>
            <th class="text-nowrap">แก้ไข</th>
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
                <div class="ellipsis-3" style="width: 15rem;"><?php echo $row['b_owner']; ?></div>
              </td>

              <td class="text-center">
                <a class="btn btn-warning" href="product.edit.php?id=<?php echo $row['id']; ?>">แก้ไข</a>
                <a class="btn btn-danger" onclick="confirmDelete('<?php echo $row['id']; ?>')">ลบ</a>
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

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: "ยืนยันการลบข้อมูล",
      text: "คุณต้องการลบข้อมูลบัญชีธนาคารนี้หรือไม่?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        location.href = `process_product.delete.php?id=${id}&action=delete`;
      }
    });
  }
</script>

<?php include('includes/footer.php'); ?>