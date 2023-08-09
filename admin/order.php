<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$seller_id = $_SESSION['seller_id'];
$sql = "SELECT * FROM orders LEFT JOIN user ON orders.user_id = user.user_id WHERE seller_id = $seller_id";
$result = $conn->query($sql);
?>

<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการออเดอร์</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    จัดการออเดอร์
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->

  <!-- begin panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">จัดการออเดอร์</h4>
    </div>
    <div class="panel-body">
      <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
        <thead>
          <tr>
            <th width="1%"></th>
            <th class="text-nowrap">ชื่อสินค้า</th>
            <th class="text-nowrap">ชื่อ-สกุลผู้สั่ง</th>
            <th class="text-nowrap">ที่อยู่</th>
            <th class="text-nowrap">เบอร์ติดต่อ</th>
            <!-- หน้าที่2 -->
            <th class="text-nowrap">ธนาคารที่โอนเข้า</th>
            <th class="text-nowrap">จำนวนเงิน</th>
            <th class="text-nowrap">วันที่ชำระเงิน</th>
            <th class="text-nowrap">สลิปการโอน</th>
            <th class="text-nowrap text-center">อัพเดจสถานะ</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row) { ?>
            <tr>
              <td class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['user_fullname']; ?></td> <!-- Assuming the column name is 'user_fullname' in 'orderss' table -->
              <td><?php echo $row['user_fullname']; ?></td> <!-- Assuming the column name is 'user_address' in 'orderss' table -->
              <td><?php echo $row['user_tel']; ?></td> <!-- Assuming the column name is 'user_tel' in 'orderss' table -->
              <td><?php echo $row['order_bank']; ?></td>
              <td><?php echo $row['order_amount']; ?></td>
              <td><?php echo $row['datatimeorder']; ?></td>
              <td><?php echo $row['updatedatatimeorder']; ?></td>
              <td><?php echo $row['payment_slip']; ?></td> <!-- Display the payment slip file name -->
              <!-- ด้านล่างอัพเดทสเตตัส -->
              <td class="text-center">
                <form action="process_order.status.php" method="POST" data-parsley-validate="true">
                  <?php if ($row['order_status'] == "paid") { ?>
                    <button type="submit" class="btn btn-<?php echo $StatusColor['preparing']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>"><?php echo $Status['preparing']; ?></button>
                  <?php } else if ($row['order_status'] == "preparing") { ?>
                    <input type="text" class="form-control w-50 mx-auto mb-1" id="order_tracking" name="order_tracking" placeholder="กรอกหมายเลขพัสดุ" data-parsley-required="true">
                    <button type="submit" class="btn btn-<?php echo $StatusColor['shipping']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>"><?php echo $Status['shipping']; ?></button>
                  <?php } else if ($row['order_status'] == "shipping") { ?>
                    <button type="button" class="btn btn-<?php echo $StatusColor['successful']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>" disabled><?php echo "รอลูกค้ารับสินค้า"; ?></button>
                  <?php } else if ($row['order_status'] == "successful") { ?>
                    <span class="badge bg-green" style="font-size: 14px">ดำเนินการสำเร็จ</span>
                  <?php } ?>
                </form>
              </td>
              <td class="text-center">
                <a class="btn btn-outline-info" href="order.detail.php?id=<?php echo $row['order_id']; ?>">ดูรายละเอียด</a>
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