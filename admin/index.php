<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$admin_id = $_SESSION['admin_id'];
$date = date_create("2202-03-07");
$date = date_format($date, "Y-m-d");
if (isset($_GET['date'])) {
	$date = date_create($_GET['date']);
	$date = date_format($date, "Y-m-d");
}
$sql = "SELECT COALESCE(ROUND(SUM(order_total_net), 2), 0)as order_total_net 
        FROM orders 
        WHERE DATE_FORMAT(createdAt, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND order_status = 'successful' 
        ORDER BY order_total_net DESC";
$result = $conn->query($sql);
$rowSumOrderTotal = $result->fetch_assoc();

$sql = "SELECT *, COALESCE(ROUND(SUM(order_total_net), 2), 0)as order_total_net 
        FROM admin 
        LEFT JOIN orders ON admin.admin_id = orders.admin_id 
        WHERE DATE_FORMAT(orders.createdAt, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND order_status = 'successful' AND admin_status = 1 
        GROUP BY admin.admin_id
        ORDER BY order_total_net DESC";
$resultSumOrderTotaladmin = $conn->query($sql);

$sql = "SELECT *, (COALESCE(SUM(order_subtotal), 0))as order_total, (COALESCE(SUM(order_qty), 0))as qty_total
        FROM product 
        LEFT JOIN order_detail ON product.product_id = order_detail.product_id 
        LEFT JOIN orders ON orders.order_id = order_detail.order_id 
        WHERE DATE_FORMAT(order_detail.createdAt, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND (SELECT order_status FROM orders WHERE order_id = order_detail.order_id) = 'successful'
        GROUP BY product.product_id 
        ORDER BY order_total DESC";
$resultSumOrderTotalProduct = $conn->query($sql);

$sql = "SELECT *, (COALESCE(SUM(order_subtotal), 0))as order_total 
        FROM product 
        LEFT JOIN brands ON product.brand_id = brands.brand_id 
        LEFT JOIN order_detail ON product.product_id = order_detail.product_id 
        LEFT JOIN orders ON orders.order_id = order_detail.order_id 
        WHERE DATE_FORMAT(order_detail.createdAt, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND (SELECT order_status FROM orders WHERE order_id = order_detail.order_id) = 'successful'
        GROUP BY product.brand_id 
        ORDER BY order_total DESC";
$resultSumOrderTotalBrand = $conn->query($sql);

$sql = "SELECT *, (COALESCE(SUM(order_subtotal), 0))as order_total 
        FROM product 
        LEFT JOIN categories ON product.category_id = categories.category_id 
        LEFT JOIN order_detail ON product.product_id = order_detail.product_id 
        LEFT JOIN orders ON orders.order_id = order_detail.order_id 
        WHERE DATE_FORMAT(order_detail.createdAt, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND (SELECT order_status FROM orders WHERE order_id = order_detail.order_id) = 'successful'
        GROUP BY product.category_id 
        ORDER BY order_total DESC";
$resultSumOrderTotalCategory = $conn->query($sql);
?>
<?php
// ตัวแปรสำหรับแปลงวันที่เป็นรูปแบบพุทธศักราช
$thaiMonths = array(
	'01' => 'มกราคม',
	'02' => 'กุมภาพันธ์',
	'03' => 'มีนาคม',
	'04' => 'เมษายน',
	'05' => 'พฤษภาคม',
	'06' => 'มิถุนายน',
	'07' => 'กรกฎาคม',
	'08' => 'สิงหาคม',
	'09' => 'กันยายน',
	'10' => 'ตุลาคม',
	'11' => 'พฤศจิกายน',
	'12' => 'ธันวาคม',
);
$currentDate = date('Y-m-d');
list($year, $month, $day) = explode('-', $currentDate);
$thaiYear = $year + 543;
$thaiDate = "{$day} {$thaiMonths[$month]} พ.ศ. {$thaiYear}";
?>
<div id="content" class="content">
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
		<li class="breadcrumb-item active">รายงานยอดขาย</li>
	</ol>
	</h1>
	<h1 class="page-header mb-5">
		รายงานยอดขาย
		<form action="#" method="get">
			<div class="row mt-2">
				<div class="col-4">
					<input type="date" class="form-control" name="date">
				</div>
				<div class="col-2">
					<button type="submit" class="btn btn-primary">ค้นหา</button>
				</div>
			</div>
		</form>
	</h1>
	<!-- end page-header -->

	<div class="row">
		<div class="col-6">
			<!-- begin panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">รายงานยอดขายประจำเดือน <?php echo $thaiMonths[$month]; ?> <?php echo $thaiYear; ?></h4>
				</div>
				<div class="panel-body">
					<h2>ยอดขายของวันนี้: <?php echo number_format(intval($rowSumOrderTotal['order_total_net'] * 100) / 100, 2); ?> ฿</h2>
				</div>
			</div>
			<!-- end panel -->

			<!-- begin panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">สินค้าขายดีของเดือนนี้</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default-1" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-nowrap">ลําดับ</th>
								<th class="text-nowrap">รูปสินค้า</th>
								<th class="text-nowrap">ชื่อร้านค้า</th>
								<th class="text-nowrap">ขายได้จำนวน(ชิ้น)</th>
								<th class="text-nowrap">ยอดขายเดือนนี้</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($resultSumOrderTotalProduct as $key => $row) { ?>
								<tr>
									<td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
									<td width="1%" class="with-img"><img src="../<?php echo $row['product_image']; ?>" class="img-rounded height-80" onError="this.src='https://thaigifts.or.th/wp-content/uploads/2017/03/no-image.jpg'" /></td>
									<td><?php echo $row['product_name']; ?></td>
									<td>x <?php echo $row['order_qty']; ?></td>
									<td><?php echo number_format(intval($row['order_total'] * 100) / 100, 2); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>

		<div class="col-6">
			<!-- begin panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">รายงานยอดขายแต่ละร้านค้าในเดือนนี้</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default-2" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-nowrap">ลําดับ</th>
								<th class="text-nowrap">ชื่อร้านค้า</th>
								<th class="text-nowrap">ยอดขายเดือนนี้</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($resultSumOrderTotaladmin as $key => $row) { ?>
								<tr>
									<td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>

									<td><?php echo $row['admin_shop']; ?></td>
									<td><?php echo number_format(intval($row['order_total_net'] * 100) / 100, 2); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->

			<!-- begin panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">แบรนด์สินค้าขายดีในเดือนนี้</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default-3" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-nowrap">ลําดับ</th>
								<th class="text-nowrap">รูปสินค้า</th>
								<th class="text-nowrap">ชื่อแบรนด์</th>
								<th class="text-nowrap">ยอดขายเดือนนี้</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($resultSumOrderTotalBrand as $key => $row) { ?>
								<tr>
									<td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
									<td width="1%" class="with-img"><img src="../<?php echo $row['brand_image']; ?>" class="img-rounded height-80" onError="this.src='https://thaigifts.or.th/wp-content/uploads/2017/03/no-image.jpg'" /></td>
									<td><?php echo $row['brand_name']; ?></td>
									<td><?php echo number_format(intval($row['order_total'] * 100) / 100, 2); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->

			<!-- begin panel -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">ประเภทสินค้าขายดีในเดือนนี้</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default-4" class="table table-bordered">
						<thead>
							<tr>
								<th class="text-nowrap">ลําดับ</th>
								<th class="text-nowrap">ประเภทสินค้า</th>
								<th class="text-nowrap">ยอดขายเดือนนี้</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($resultSumOrderTotalCategory as $key => $row) { ?>
								<tr>
									<td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
									<td><?php echo $row['category_name']; ?></td>
									<td><?php echo number_format(intval($row['order_total'] * 100) / 100, 2); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end panel -->
		</div>
	</div>
</div>
<!-- end #content -->

<?php include('includes/footer.php'); ?>

<script>
	$('#data-table-default-1').DataTable();
	$('#data-table-default-2').DataTable();
	$('#data-table-default-3').DataTable();
	$('#data-table-default-4').DataTable();
</script>