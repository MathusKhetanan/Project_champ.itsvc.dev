<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$sql = "SELECT * FROM brands";
$result = $conn->query($sql);
?>

<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการแบรนด์</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    จัดการแบรนด์
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->

  <!-- begin panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">จัดการแบรนด์</h4>
      <div class="btn-group">
        <a href="brand.add.php" class="btn btn-success btn-xs">เพิ่มข้อมูลแบรนด์</a>
      </div>
    </div>
    <div class="panel-body" style="overflow-y: scroll;">
      <table id="data-table-default" class="table table-bordered">
        <thead>
          <tr>
          <th class="text-nowrap">ลําดับ</th>
            <th class="text-nowrap">รูปแบรนด์</th>
            <th class="text-nowrap">ชื่อแบรนด์</th>
            <th class="text-nowrap text-center">ตัวเลือก</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row) { ?>
            <tr>
              <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
              <td width="1%" class="with-img"><img src="../<?php echo $row['brand_image']; ?>" class="img-rounded height-30" onError="this.src='https://media.discordapp.net/attachments/1128198864629940244/1144291779957510274/istockphoto-1221460403-170667a_prev_ui.png?width=473&height=473'"/></td>
              <td><?php echo $row['brand_name']; ?></td>
              <td class="text-center">
    <a class="btn btn-warning" href="brand.edit.php?id=<?php echo $row['brand_id']; ?>">แก้ไข</a>
    <a class="btn btn-danger" onclick="confirmDelete(<?php echo $row['brand_id']; ?>)">ลบ</a>
</td>

<script>
    function confirmDelete(brandId) {
        Swal.fire({
            title: 'คุณต้องการลบข้อมูลแบรนด์นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = `process_brand.delete.php?id=${brandId}&action=delete`;
            }
        });
    }
</script>
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