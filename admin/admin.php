<?php 
  include('../config.php');
  include('includes/authentication.php'); 
  include('includes/header.php');   

  $sql = "SELECT * FROM seller";
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
            <th width="1%"></th>
            <th class="text-nowrap">ชื่อร้านค้า</th>
            <th class="text-nowrap">ชื่อบัญชีผู้ขาย</th>
            <th width="15rem" class="text-nowrap">อีเมล</th>
            <th class="text-nowrap">ชื่อ-นามสกลุผู้ขาย</th>
            <th class="text-nowrap">ที่อยู่ร้านค้า</th>
            <th class="text-nowrap">เบอร์ติดต่อ</th>
            <th class="text-nowrap text-center">ชื่อธนคาร</th>
            <th class="text-nowrap text-center">เลขที่บัญชี</th>
            <th class="text-nowrap text-center">ตัวเลือก</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row){ ?>
          <tr>
            <td width="1%" class="f-s-600 text-inverse"><?php echo $key+1; ?></td>
            <td><?php echo $row['seller_shop']; ?></td>
            <td><?php echo $row['seller_username']; ?></td>
            <td><?php echo $row['seller_email']; ?></td>
            <td><?php echo $row['seller_username']; ?></td>
            <td><div class="ellipsis-3" style="width: 10rem;"><?php echo $row['seller_address']; ?></div></td>
            <td><?php echo $row['seller_tel']; ?></td>
            <td><?php echo $row['seller_bank_name']; ?></td>  
            <td><?php echo $row['seller_account_number']; ?></td>
            <td class="text-center">
              <a class="btn btn-danger" onclick="if(confirm('คุณต้องการลบข้อมูลแอดมินนี้หรือไม่?')){ location.href = 'process_admin.delete.php?id=<?php echo $row['seller_id']; ?>&action=delete' };">ลบ</a>
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
