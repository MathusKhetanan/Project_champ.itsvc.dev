<?php 
			include('config.php'); 
			include('includes/authentication.php'); 
			include('includes/header.php'); 

			$sql = "SELECT * FROM product LIMIT 6";
			$resultTrending = $conn->query($sql);

			$sql = "SELECT * FROM brands";
			$resultBrands = $conn->query($sql);

			$user_id = $_SESSION['user_id'];
      $sql = "SELECT * FROM orders LEFT JOIN seller ON orders.seller_id = seller.seller_id WHERE user_id = $user_id";
      $result = $conn->query($sql);
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
					<div class="account-body" style="height: 100%;min-height: 650px;background-color: #d9e0e7; overflow: scroll;">
						<!-- BEGIN row -->
						<div class="row">
							<!-- BEGIN col-6 -->
							<div class="col-md-12">
								<!-- begin panel -->
								<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
									<thead>
										<tr>
											<th width="1%"></th>
											<th class="text-nowrap">ชื่อผู้ขาย</th>
											<th class="text-nowrap">เบอร์ติดต่อ</th>
											<th class="text-nowrap">ราคารวม</th>
											<th class="text-nowrap text-center">สถานะออเดอร์</th>
											<th class="text-nowrap">สั่งซื้อเมื่อ</th>
											<th class="text-nowrap">เลขที่อ้างอิง</th>
											<th class="text-nowrap text-center">ดูรายการคำสั่งซื้อ</th>
											<th class="text-nowrap text-center">อัพเดจสถานะ</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($result as $key => $row){ ?>
										<tr>
											<td width="1%" class="f-s-600 text-inverse"><?php echo $key+1; ?></td>
											<td><?php echo $row['seller_fullname']; ?></td>
											<td><?php echo $row['seller_tel']; ?></td>
											<td><?php echo $row['order_total']; ?></td>
											<td class="text-center"><span class="badge bg-<?php echo $StatusColor[$row['order_status']]; ?>" style="font-size: 14px"><?php echo $Status[$row['order_status']]; ?></span></td>
											<td><?php echo $row['createdAt']; ?></td>
											<td><?php echo $row['order_ref']; ?></td>
											</td>
											<td class="text-center">
												<a class="btn btn-outline-info" href="order.detail.php?id=<?php echo $row['order_id']; ?>">ดูรายละเอียด</a>
											</td>
											<td class="text-center">
												<button class="btn btn-success" <?php echo ($row['order_status'] != "shipping")?"disabled" :"" ?> onclick="if(confirm('คุณต้องการลบข้อมูลแบรนด์นี้หรือไม่?')){ location.href = 'process_order.status.php?change_status=<?php echo $row['order_id']; ?>&action=update' };">ยืนยันการรับสินค้า</button>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<!-- end panel -->
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