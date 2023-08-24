		<?php
		include('../config.php');
		include('includes/authentication.php');
		include('includes/header.php');

		$order_id = $conn->real_escape_string($_GET['id']);
		$sql = "SELECT * FROM orders LEFT JOIN user ON orders.user_id = user.user_id LEFT JOIN admin ON orders.admin_id = admin.admin_id WHERE order_id = $order_id";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		$sql = "SELECT * FROM order_detail WHERE order_id = $order_id";
		$result = $conn->query($sql);
		?>

		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
				<li class="breadcrumb-item"><a href="order.php">จัดการออเดอร์</a></li>
				<li class="breadcrumb-item active">รายละเอียดออเดอร์</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">
				รายละเอียดออเดอร์
				<!-- <small>header small text goes here...</small> -->
			</h1>
			<!-- end page-header -->

			<!-- begin invoice -->
			<div class="invoice">
				<!-- begin invoice-company -->
				<div class="invoice-company">
					<div class="row">
						<div class="col-5">
							ร้าน: <?php echo $row['admin_shop']; ?>
						</div>
						<div class="col-7.5 d-flex justify-content-end">
							อัพเดจสถานะ:
							<form action="process_order.detail.status.php?id=<?php echo $row['order_id']; ?>" class="ml-2 mr-2" method="POST">
								<button type="submit" class="btn btn-<?php echo $StatusColor['paid']; ?>" name="change_status" value="paid"><?php echo $Status['paid']; ?></button>
							</form>
							<form action="process_order.detail.status.php?id=<?php echo $row['order_id']; ?>" class="ml-2 mr-3" method="POST">
								<button type="submit" class="btn btn-<?php echo $StatusColor['preparing']; ?>" name="change_status" value="preparing"><?php echo $Status['preparing']; ?></button>
							</form>
							<form action="process_order.detail.status.php?id=<?php echo $row['order_id']; ?>" class="ml-2 mr-3" method="POST">
								<button type="submit" class="btn btn-success" name="change_status" value="successful">ยืนยันการรับสินค้า</button>
							</form>
							<form action="process_order.detail.status.php?id=<?php echo $row['order_id']; ?>" class="row d-flex justify-content-end" method="POST">
								<input type="text" class="form-control w-50 mr-3" id="order_tracking" name="order_tracking" placeholder="กรอกหมายเลขออเดอร์" required>
								<button type="submit" class="btn btn-<?php echo $StatusColor['shipping']; ?>" name="change_status" value="shipping">อัพเดทหมายเลขออเดอร์</button>
							</form>

						</div>
					</div>
				</div>
				<!-- end invoice-company -->
				<!-- begin invoice-header -->
				<div class="invoice-header">
					<div class="invoice-from">
						<small>จาก</small>
						<address class="m-t-5 m-b-5">
							<strong class="text-inverse"><?php echo $row['admin_fullname']; ?>.</strong><br />
							<?php echo $row['admin_address']; ?>
						</address>
					</div>
					<div class="invoice-to">
						<small>ถึง</small>
						<address class="m-t-5 m-b-5">
							<strong class="text-inverse"><?php echo $row['user_fullname']; ?></strong><br />
							<?php echo $row['user_address']; ?>
						</address>
					</div>
					<div class="invoice-date">
						<small>สถานะออเดอร์ / <span class="badge bg-<?php echo $StatusColor[$row['order_status']]; ?>" style="font-size: 12px"><?php echo $Status[$row['order_status']]; ?></span></small><br />
						หมายเลขออเดอร์: <?php echo $row['order_tracking']; ?>
						<div class="date text-inverse m-t-5"><?php echo $row['createdAt']; ?></div>
						<div class="invoice-detail">
							#ref-<?php echo $row['order_ref']; ?><br />
						</div>
					</div>
				</div>
				<!-- end invoice-header -->
				<!-- begin invoice-content -->
				<div class="invoice-content">
					<!-- begin table-responsive -->
					<div class="table-responsive">
						<table class="table table-invoice">
							<thead>
								<tr>
									<th>ชื่อสินค้า</th>
									<th class="text-center" width="10%">ราคา</th>
									<th class="text-center" width="10%">จำนวน</th>
									<th class="text-right" width="10%">รวมทั้งหมด</th>
								
									<th class="text-right" width="15%">รวม</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$total = 0;
								foreach ($result as $key => $item) {
									$total += $item['order_subtotal'];

									$free = number_format(($item['order_subtotal'] * $row['order_total_free']) / 100, 2);
									$free_vat = number_format(($free * $row['order_total_free_vat']) / 100, 2);
								?>
									<tr>
										<td>
											<span class="text-inverse"><?php echo $item['product_name']; ?></span>
										</td>
										<td class="text-center"><?php echo $item['product_price']; ?></td>
										<td class="text-center">x <?php echo $item['order_qty']; ?></td>
										<td class="text-right"><?php echo $item['order_subtotal']; ?></td>
										
										<td class="text-right"><?php echo $item['order_subtotal'] - ($free + $free_vat); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<!-- end table-responsive -->
					<!-- begin invoice-price -->
					<div class="invoice-price">
						<div class="invoice-price-left">
							<div class="invoice-price-row">
								<div class="sub-price">
									<small>รวมทั้งหมด</small>
									<span class="text-inverse"><?php echo $row['order_total']; ?></span>
								</div>
						
							
							</div>
						</div>
						<div class="invoice-price-right">
							<small>จำนวนนวนเงินที่ได้รับ</small> <span class="f-w-600"><?php echo $row['order_total']; ?> ฿</span>
						</div>
					</div>
					<!-- end invoice-price -->
				</div>
				<!-- end invoice-content -->
				<!-- begin invoice-footer -->
				<div class="invoice-footer">
					<p class="text-center m-b-5 f-w-600">
						ขอบคุณสำหรับธุรกิจของคุณ
					</p>
					<p class="text-center">
						<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> ติดต่อ: <?php echo $row['admin_tel']; ?></span>
						<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?php echo $row['admin_email']; ?></span>
					</p>
				</div>
				<!-- end invoice-footer -->
			</div>
			<!-- end invoice -->
		</div>
		<!-- end #content -->

		<?php include('includes/footer.php'); ?>