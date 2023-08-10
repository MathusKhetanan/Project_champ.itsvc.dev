<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');
// 7,783.65
$seller_id = $_SESSION['seller_id'];
$sql = "SELECT *, COALESCE(ROUND(SUM(order_total_net), 2), 0) as sumTotal FROM orders WHERE seller_id = $seller_id AND order_status = 'successful'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$seller_id = $_SESSION['seller_id'];
$sql = "SELECT COALESCE(SUM(withdraw_money), 0) as withdrawPending, COALESCE(SUM(withdraw_fee), 0) as withdrawFeePending FROM withdraw WHERE seller_id = $seller_id AND withdraw_status = 'pending' OR withdraw_status = 'wait_confirm'";
$result = $conn->query($sql);
$row2 = $result->fetch_assoc();

$seller_id = $_SESSION['seller_id'];
$sql = "SELECT COALESCE(SUM(withdraw_money), 0) as withdrawSuccessful, COALESCE(SUM(withdraw_fee), 0) as withdrawFeeSuccessful FROM withdraw WHERE seller_id = $seller_id AND withdraw_status = 'successful'";
$result = $conn->query($sql);
$row3 = $result->fetch_assoc();

$sql = "SELECT * FROM withdraw WHERE seller_id = $seller_id";
$result = $conn->query($sql);
?>

<style>
  .widget {
    height: 120px;
  }

  .stats-content .stats-title {
    font-size: 16px !important;
  }
</style>

<!-- begin #content -->
<div id="content" class="content">
  <!-- begin breadcrumb -->
  <ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
    <li class="breadcrumb-item active">จัดการถอนเงิน</li>
  </ol>
  <!-- end breadcrumb -->
  <!-- begin page-header -->
  <h1 class="page-header">
    จัดการถอนเงิน
    <!-- <small>header small text goes here...</small> -->
  </h1>
  <!-- end page-header -->

  <!-- begin row -->
  <div class="row">
    <!-- begin col-3 -->
    <div class="col-xl-4 col-md-6">
      <div class="widget widget-stats bg-teal">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-money-bill"></i></div>
        <div class="stats-content">
          <div class="stats-title">ยอดเงินคงเหลือ</div>
          <div class="stats-number"><?php echo number_format(intval(($row['sumTotal'] - ($row2['withdrawPending'] + $row2['withdrawFeePending'] + $row3['withdrawSuccessful'] + $row3['withdrawFeeSuccessful'])) * 100) / 100, 2); ?></div>
        </div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-xl-4 col-md-6">
      <div class="widget widget-stats bg-indigo">
        <div class="stats-icon stats-icon-lg"><i class="fa fa fa-share fa-fw"></i></div>
        <div class="stats-content">
          <div class="stats-title">กำลังรอถอนเงิน</div>
          <div class="stats-number"><?php echo number_format(intval($row2['withdrawPending'] * 100) / 100, 2); ?></div>
        </div>
      </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-xl-4 col-md-6">
      <div class="widget widget-stats bg-dark">
        <div class="stats-icon stats-icon-lg"><i class="fa fa fa-coins fa-fw"></i></div>
        <div class="stats-content">
          <div class="stats-title">ถอนเงินทั้งหมด</div>
          <div class="stats-number"><?php echo number_format(intval($row3['withdrawSuccessful'] * 100) / 100, 2); ?></div>
        </div>
      </div>
    </div>
    <!-- end col-3 -->
  </div>
  <!-- end row -->

  <!-- begin row -->
  <form action="process_withdraw.php" method="POST" data-parsley-validate="true">
    <div class="row d-flex justify-content-center mb-4">
      <!-- begin col-3 -->
      <div class="col-xl-3 col-md-4">
        <input type="text" class="form-control form-control-lg mb-1" id="withdraw_money" name="withdraw_money" placeholder="กรอกจำนวนเงิน (ขั้นต่ำ: 100 ฿, สูงสุด: <?php echo number_format(intval(($row['sumTotal'] - ($row2['withdrawPending'] + $row3['withdrawSuccessful'])) * 100) / 100, 2); ?>฿)" data-parsley-required="true" data-parsley-type="number" data-parsley-min="100" data-parsley-max="<?php echo $row['sumTotal'] - ($row2['withdrawPending'] + $row3['withdrawSuccessful']); ?>">
        <p class="text-center">* ค่าธรรมเนียม 3% ของยอดที่ถอน</p>
      </div>
      <div class="col-xl-1 col-md-3">
        <button type="submit" class="btn btn-purple btn-lg w-100" <?php echo ($_SESSION['seller_payment'] == "") ? "disabled" : ""; ?>><?php echo ($_SESSION['seller_payment'] == "") ? "กรุณาตรวจสอบบัญชีของท่าน" : "ถอนเงิน"; ?></button>
      </div>
      <!-- end col-3 -->
    </div>
  </form>
  <!-- end row -->

  <!-- begin panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">ประวัติการถอนเงิน</h4>
    </div>
    <div class="panel-body" style="overflow-y: scroll;">
      <table id="data-table-default" class="table table-bordered">
        <thead>
          <tr>
            <th width="1%">ลำดับ</th>
            <th>รหัสการถอนเงิน</th>
            <th class="text-nowrap">จำนวนเงิน</th>
            <th class="text-nowrap">ค่า fee</th>
            <th class="text-nowrap text-center">สถานะการถอน</th>
            <th class="text-nowrap">เวลาถอนเงิน</th>
            <th class="text-nowrap text-center">เปลี่ยนสถานะ</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $key => $row) { ?>
            <tr>
              <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
              <td><?php echo substr(md5($row['withdraw_id']), 0, 8); ?></td>
              <td><?php echo number_format(intval($row['withdraw_money'] * 100) / 100, 2); ?></td>
              <td><?php echo number_format(intval($row['withdraw_fee'] * 100) / 100, 2); ?></td>
              <td class="text-center"><span class="badge bg-<?php echo $StatusWithdrawColor[$row['withdraw_status']]; ?>" style="font-size: 14px"><?php echo $StatusWithdraw[$row['withdraw_status']]; ?></span></td>
              <td><?php echo $row['createdAt']; ?></td>
              <td class="text-center">
                <button class="btn btn-warning" onclick="if(confirm('ยืนยันการได้รับเงิน?')){ location.href = 'process_withdraw.php?id=<?php echo substr(md5($row['withdraw_id']), 0, 8); ?>&action=update' }" <?php echo ($row['withdraw_status'] != 'wait_confirm') ? "disabled" : ""; ?>>ยืนยันการได้รับเงิน</button>
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