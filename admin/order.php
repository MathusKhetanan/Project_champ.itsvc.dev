<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$seller_id = $_SESSION['seller_id'];

// ดึงข้อมูลออเดอร์
$sql_orders = "SELECT * FROM orders";
$result_orders = $conn->query($sql_orders);

// ดึงข้อมูลธนาคาร
$sql_banks = "SELECT * FROM tbl_bank";
$result_banks = $conn->query($sql_banks);

// ดึงข้อมูลสินค้า
$sql_product = "SELECT * FROM product";
$result_products = $conn->query($sql_product);
?>

<div id="content" class="content">
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการออเดอร์</li>
  </ol>
  <h1 class="page-header">จัดการออเดอร์</h1>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">จัดการออเดอร์</h4>
    </div>
    <div class="panel-body">
      <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
        <thead>
          <tr>
            <th class="text-nowrap">ลําดับ</th>
            <th class="text-nowrap">ชื่อสินค้า</th>
            <th class="text-nowrap">ชื่อ-สกุลผู้สั่ง</th>
            <th class="text-nowrap">ที่อยู่</th>
            <th class="text-nowrap">เบอร์ติดต่อ</th>
            <th class="text-nowrap">ธนาคารที่โอนเข้า</th>
            <th class="text-nowrap">จำนวนเงิน</th>
            <th class="text-nowrap">วันที่ชำระเงิน</th>
            <th class="text-nowrap text-center">อัพเดตสถานะ</th>
            <th class="text-center">รายละเอียด</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result_orders as $key => $row) { ?>
            <tr>
              <td><?php echo $row['order_id']; ?></td>
              <td>
                <?php
                // ค้นหาชื่อสินค้าจาก $result_products ที่มี product_id เท่ากับ product_name
                $product_name = '';
                foreach ($result_products as $product_row) {
                  if ($product_row['product_id'] == $row['product_name']) {
                    $product_name = $product_row['product_name'];
                    break;
                  }
                }
                echo $product_name;
                ?>
              </td>
              <td><?php echo $row['order_fullname']; ?></td>
              <td><?php echo $row['order_address']; ?></td>
              <td><?php echo $row['order_tel']; ?></td>
              <td>
                <?php
                // ค้นหาชื่อธนาคารจาก $result_banks ที่มี id เท่ากับ order_bank
                $bank_name = '';
                foreach ($result_banks as $bank_row) {
                  if ($bank_row['id'] == $row['order_bank']) {
                    $bank_name = $bank_row['b_name'];
                    break;
                  }
                }
                echo $bank_name;
                ?>
              </td>
              <td><?php echo $row['order_amount']; ?></td>
              <td><?php echo $row['datatimeorder']; ?></td>

              <td class="text-center">
                <form action="process_order.status.php" method="POST" data-parsley-validate="true">
                  <?php if ($row['order_status'] == "paid") { ?>
                    <button type="submit" class="btn btn-<?php echo $StatusColor['preparing']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>"><?php echo $Status['preparing']; ?></button>
                  <?php } else if ($row['order_status'] == "preparing") { ?>
                    <input type="text" class="form-control w-50 mx-auto mb-1" id="order_tracking" name="order_tracking" placeholder="กรอกหมายเลขพัสดุ" data-parsley-required="true">
                    <button type="submit" class="btn btn-<?php echo $StatusColor['shipping']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>"><?php echo $Status['shipping']; ?></button>
                  <?php } else if ($row['order_status'] == "shipping") { ?>
                    <button type="button" class="btn btn-<?php echo $StatusColor['successful']; ?>" name="change_status" value="<?php echo $row['order_id']; ?>" disabled>รอลูกค้ารับสินค้า</button>
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
</div>

<?php include('includes/footer.php'); ?>