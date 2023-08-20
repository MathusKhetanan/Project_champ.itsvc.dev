<?php
include('config.php');
include('includes/authentication.php');
include('includes/header.php');

$user_id = $_SESSION['user_id']; // ให้กำหนดค่า $user_id ก่อนใช้งานใน SQL query

$sql = "SELECT * FROM product LIMIT 6";
$resultTrending = $conn->query($sql);

$sql = "SELECT * FROM brands";
$resultBrands = $conn->query($sql);

$sql = "SELECT *, DATE_FORMAT(orders.createdAt, '%d/%m/%Y %H:%i:%s') AS formattedCreatedAt FROM orders LEFT JOIN seller ON orders.seller_id = seller.seller_id WHERE user_id = $user_id ORDER BY orders.createdAt DESC"; // Order by createdAt in descending order
$resultdate = $conn->query($sql);

$sql = "SELECT orders.*, seller.seller_fullname, seller.seller_tel, DATE_FORMAT(orders.createdAt, '%d/%m/%Y %H:%i:%s') AS formattedCreatedAt FROM orders LEFT JOIN seller ON orders.seller_id = seller.seller_id WHERE user_id = $user_id ORDER BY orders.createdAt DESC"; // Order by createdAt in descending order
$result = $conn->query($sql);
// เพิ่มข้อมูลในตาราง
for ($i = 0; $i < 10; $i++) {
	$result->fetch_assoc(); // หากมีข้อมูลจริงให้ใส่ข้อมูลจริงแทน
}

?>

<!-- BEGIN #my-account -->
<div id="about-us-cover" class="section-container" style="margin-bottom: 3rem">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN breadcrumb -->
		<ul class="breadcrumb mb-3">
			<li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
			<li class="breadcrumb-item active">บัญชีของฉัน</li>
		</ul>
		<!-- END breadcrumb -->
		<!-- BEGIN account-container -->
		<div class="account-container">
			<?php include('includes/profile.menu.php');  ?>
			<!-- BEGIN account-body -->
			<div class="account-body" style="background-color: #d9e0e7; overflow-y: auto;">
				<!-- BEGIN row -->
				<div class="row">
					<!-- BEGIN col-6 -->
					<div class="col-md-12"> <!-- เพิ่ม class "ml-auto" เพื่อชิดซ้ายมือ -->
						<!-- begin panel -->
						<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle" style="width: auto; white-space: nowrap;">
							<thead>
								<tr>
									<th class="text-nowrap text-center">ลําดับ</th>
									<th class="text-nowrap text-center">ชื่อผู้ขาย</th>
									<th class="text-nowrap text-center">ราคารวม</th>
									<th class="text-nowrap text-center">สถานะออเดอร์</th>
									<th class="text-nowrap text-center">สั่งซื้อเมื่อ</th>
									<th class="text-nowrap text-center">ดูรายการคำสั่งซื้อ</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result as $key => $row) { ?>
									<tr>
										<td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
										<td><?php echo $row['seller_fullname']; ?></td>
										<td><?php echo (floor($row['order_total']) == $row['order_total']) ? number_format($row['order_total'], 0) : number_format($row['order_total'], 2); ?></td>
										<td class="text-center"><span class="badge bg-<?php echo $StatusColor[$row['order_status']]; ?>" style="font-size: 14px"><?php echo $Status[$row['order_status']]; ?></span></td>
										<td><?php echo isset($row['formattedCreatedAt']) ? $row['formattedCreatedAt'] : ''; ?></td>
										<td>
											<a class="btn btn-outline-info" href="order.detail.php?id=<?php echo $row['order_id']; ?>">ดูรายละเอียด</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<!-- end panel -->
					</div>
				</div>
				<!-- END col-6 -->
			</div>
			<!-- END row -->
		</div>
		<!-- END account-body -->
	</div>
	<!-- END account-container -->
</div>
<!-- END container -->
</div>
<!-- END #about-us-cover -->

<?php include('includes/footer.php'); ?>
