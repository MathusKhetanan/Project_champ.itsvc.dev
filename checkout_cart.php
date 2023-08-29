<?php
include('config.php');
include('includes/authentication.php');
include('includes/header.php');
$sql = "SELECT * FROM `tbl_bank`";
$result = $conn->query($sql);

// ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
if (isset($_SESSION['items']) && is_array($_SESSION['items']) && count($_SESSION['items']) > 0) {
	$totalPrice = 0;

	// หาราคารวมของสินค้าในตะกร้า
	foreach ($_SESSION['items'] as $item) {
		$totalPrice += $item['price'] * $item['qty'];
	}
} else {
	// กรณีไม่มีสินค้าในตะกร้า
	$totalPrice = 0;
}
?>

<style>
	/* CSS */
	/* ปรับสีพื้นหลังของปุ่มเมื่อเมาส์ไปชี้ (hover) */
	.form-check-input:hover {
		background-color: #f0f0f0;
		/* เปลี่ยนสีพื้นหลังเมื่อ hover */
	}

	/* ปรับสีของข้อความของปุ่ม */
	.form-check-label {
		color: #333;
		/* เปลี่ยนสีข้อความ */
	}

	.sw-main.sw-theme-default .step-anchor {
		background: #343a40;
	}

	.sw-main.sw-theme-default .step-anchor>li.active {
		background: #303030 !important;
	}

	.sw-theme-default>ul.step-anchor>li.done>a {
		color: #6f8293 !important;
	}

	.sw-main.sw-theme-default .step-anchor>li.done>a .number:before {
		background: #d5dbe0 !important;
		color: #4d353c !important;
	}

	.nav.nav-tabs .nav-item .nav-link:hover {
		color: #fff;
	}

	.sw-main.sw-theme-default .sw-toolbar {
		background: #dee2e6;
	}

	.sw-theme-default .sw-toolbar-bottom {
		padding: 1.5625rem 1.875rem !important;
	}

	.btn-group,
	.btn-group-vertical {
		display: block;
	}

	.sw-btn-prev {
		color: #212529 !important;
		background-color: #fff !important;
		border-color: #fff !important;
		-webkit-box-shadow: 0 !important;
		box-shadow: 0 !important;
	}

	.sw-btn-prev,
	.sw-btn-next {
		width: 12.5rem !important;

		font-size: 1rem;

		color: #fff;
		background-color: #2d353c;
		border-color: #2d353c;

		padding: .75rem 1.875rem;
		font-weight: 700;
		-webkit-border-radius: 6px;
		border-radius: 6px;
	}

	/* สไตล์ของช่องแนบสลิป */
	input[type="file"] {
		border: 2px solid #3498db;
		/* สีขอบช่องแนบ */
		background-color: #f0f0f0;
		/* สีพื้นหลังช่องแนบ */
		color: #333;
		/* สีข้อความในช่องแนบ */
		padding: 10px;
		/* ระยะห่างของข้อความภายในช่องแนบ */
		border-radius: 5px;
		/* ขอบมนของช่องแนบ */
		font-size: 16px;
		/* ขนาดตัวอักษรข้อความในช่องแนบ */
	}

	/* สไตล์ของช่องแนบสลิปเมื่อได้รับการโฟกัส */
	input[type="file"]:focus {
		outline: none;
		/* ไม่แสดงเส้นขอบ (outline) เมื่อได้รับการโฟกัส */
		border-color: #0078d4;
		/* เปลี่ยนสีขอบช่องแนบเมื่อได้รับการโฟกัส */
		box-shadow: 0 0 5px rgba(0, 120, 212, 0.5);
		/* เพิ่มเงาเมื่อได้รับการโฟกัส */
	}

	/* ปรับสไตล์ของ radio button */
	.form-check-input {
		margin-right: 100%;
		/* ระยะห่างทางขวาของ label */
		vertical-align: middle;
		/* ยืดให้ radio button อยู่กลางแนวตั้ง */
	}

	/* ปรับสไตล์ของ label */
	.col-form-label {
		position: relative;
		top: 2px;
		/* ย้ายข้อความขึ้นไป 10px */
		margin-bottom: 0;
		/* ไม่ให้ label ขยับลงล่าง */
	}

	/* ปรับสไตล์ของ form-check */
	.form-check {
		margin-bottom: 11px;
		/* เพิ่มระยะห่างระหว่างรายการเลือกธนาคาร */
		display: flex;
		/* ให้รายการเลือกธนาคารแสดงแนวนอน */
		align-items: center;
		/* จัดให้อยู่กลางแนวตั้ง */
	}

	/* ปรับสไตล์ของ label */
	.form-check-label {
		flex: 1;
		/* ขยาย label เพื่อรับพื้นที่ทั้งหมดที่เหลือ */
		position: relative;
		top: -5px;
		/* ย้ายข้อความขึ้นไป 8px (คล้ายกับการขยับขึ้น 10px) */
		margin-bottom: 0;
		/* ไม่ให้ label ขยับลงล่าง */
		display: flex;
		align-items: center;
		/* จัดให้อยู่กลางแนวตั้ง */
	}

	/* ปรับสไตล์ของรูปภาพโลโก้ */
	.form-check-label img {
		margin-right: 10px;
		/* ระยะห่างทางขวาของรูปภาพโลโก้ */
	}

	.form-check-input[type="radio"] {
		flex: 1;
		/* ขยาย label เพื่อรับพื้นที่ทั้งหมดที่เหลือ */

		top: 10px;
	}

	/* เริ่มต้นโดยซ่อนส่วนนี้ */
	#hidden-step-3 {
		display: none;
	}

	/* แสดงส่วนนี้เมื่อมีเงื่อนไขที่เหมาะสม เช่น เมื่อมีการอัปโหลดสลิป */
	#hidden-step-3.visible {
		display: block;
	}
</style>

<!-- BEGIN #checkout-cart -->
<div class="section-container" id="checkout-cart">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN checkout -->
		<div class="checkout">
			<!-- begin wizard-form -->
			<form action="process_checkout.php" method="POST" name="form-wizard" class="form-control-with-bg">
				<input type="hidden" name="amount"> <!-- เพิ่มค่าเงินจากราคาสินค้าที่ถูกคำนวณ -->
				<input type="hidden" name="items">
				<input type="hidden" name="omiseToken">
				<!-- begin wizard -->
				<div id="wizard">
					<!-- begin wizard-step -->
					<ul>
						<li>
							<a href="#step-1">
								<span class="number">1</span>
								<span class="info">
									จัดการตะกร้าสินค้า
									<small>Lorem ipsum dolor sit amet.</small>
								</span>
							</a>
						</li>
						<li>
							<a href="#step-2">
								<span class="number">2</span>
								<span class="info">
									จัดการที่อยู่
									<small>Vivamus eleifend euismod.</small>
								</span>
							</a>
						</li>
						<li>
							<a href="#step-3">
								<span class="number">3</span>
								<span class="info">
									จัดการชำระเงิน
									<small>Aenean ut pretium ipsum.</small>
								</span>
							</a>
						</li>
						<!-- <li>
											<a href="#step-4">
												<span class="number">4</span> 
												<span class="info">
													Complete Payment
													<small>Curabitur interdum libero.</small>
												</span>
											</a>
										</li> -->
					</ul>
					<!-- end wizard-step -->
					<!-- begin wizard-content -->
					<div>
						<!-- begin step-1 -->
						<div id="step-1" class="checkout p-0">
							<!-- begin fieldset -->
							<fieldset>
								<!-- BEGIN checkout-body -->
								<div class="checkout-body">
									<div class="table-responsive">
										<table class="table table-cart">

										</table>
									</div>
								</div>
								<!-- END checkout-body -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-1 -->
						<!-- begin step-2 -->
						<div id="step-2">
							<!-- begin fieldset -->
							<fieldset>
								<!-- BEGIN checkout-body -->
								<div class="checkout-body">
									<div class="form-group row">
										<label class="col-form-label col-md-4 text-lg-right">
											ชื่อ-สกุล <span class="text-danger">*</span>
										</label>
										<div class="col-md-4">
											<input type="text" placeholder="ชื่อ-สกุล" name="user_fullname" data-parsley-group="step-2" class="form-control" data-parsley-required="true" value="<?php echo $_SESSION['user_fullname']; ?>" />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-form-label col-md-4 text-lg-right">
											ที่อยู่ <span class="text-danger">*</span>
										</label>
										<div class="col-md-4">
											<textarea name="user_address" placeholder="ที่อยู่" class="form-control" data-parsley-group="step-2" data-parsley-required="true" rows="3"><?php echo $_SESSION['user_address']; ?></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-form-label col-md-4 text-lg-right">
											เบอร์ติดต่อ <span class="text-danger">*</span>
										</label>
										<div class="col-md-4">
											<input type="text" name="user_tel" placeholder="เบอร์ติดต่อ" class="form-control" data-parsley-group="step-2" data-parsley-required="true" value="<?php echo $_SESSION['user_tel']; ?>" />
										</div>
									</div>
								</div>
								<!-- END checkout-body -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-2 -->
						<div id="step-3">
							<!-- รายละเอียดการชำระเงินและแนบสลิป -->
							<!-- ส่วนของรายละเอียดการชำระเงินและแนบสลิป -->
							<div class="form-group row">
								<label class="col-md-4 col-form-label text-lg-right">เลือกธนาคาร: <span class="text-danger">*</span></label>
								<div class="col-md-8">
									<?php
									$sql = "SELECT * FROM `tbl_bank`";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo '<div class="form-check">';
											echo '<input class="form-check-input" type="radio" name="bank" id="bank' . $row['id'] . '" value="' . $row['id'] . '" required>';
											echo '<label class="form-check-label" for="bank' . $row['id'] . '">';
											echo '<img src="' . $row['b_logo'] . '" alt="' . $row['b_name'] . ' Logo" width="50" height="50">'; // แสดงโลโก้
											echo ' ' . $row['b_name'] . ' &nbsp;&nbsp;&nbsp; ' . $row['b_number'] . ' &nbsp;&nbsp;&nbsp; ' . $row['bn_name']  . ' &nbsp;&nbsp;&nbsp; ' . $row['b_owner'];
											echo '</label>';
											echo '</div>';
										}
									}
									?>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-4 col-form-label text-lg-right">
									จำนวนเงิน <span class="text-danger">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" placeholder="ชื่อ-สกุล" id="userFullname" name="user_fullname" data-parsley-group="step-3" class="form-control" data-parsley-required="true" readonly disabled value="<?php echo $_SESSION['user_fullname']; ?>" />
								</div>
							</div>


							<script>
								const totalPrice = <?php echo $totalPrice; ?>;
								document.getElementById('totalPrice').textContent = totalPrice.toFixed(2) + ' ฿';
							</script>
							<!-- ตรวจสอบการอัปโหลดสลิป -->
							<div class="form-group row">
								<label class="col-md-4 col-form-label text-lg-right">แนบสลิป <span class="text-danger">*</span></label>
								<div class="col-md-4">
									<input type="file" class="form-control-file" name="slip" accept=".pdf,.jpg,.png" onchange="getSlipData()" required />
									<small class="text-muted">รองรับไฟล์ PDF, JPG, และ PNG</small>
								</div>
							</div>

							<div id="hidden-step-3">
								<!-- ... ส่วนที่คุณต้องการซ่อน -->
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">ชื่อบนบัตร <span class="text-danger">*</span></label>
									<div class="col-md-4">
										<input type="text" class="form-control required" name="cardHolder" placeholder="" value="TEST" />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">หมายเลขบัตร <span class="text-danger">*</span></label>
									<div class="col-md-4">
										<input type="text" class="form-control required" name="cardNumber" placeholder="" value="4242424242424242" />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">วันหมดอายุ <span class="text-danger">*</span></label>
									<div class="col-md-8">
										<div class="width-100">
											<div class="row row-space-0">
												<div class="col-5">
													<input type="text" name="mm" placeholder="MM" class="form-control required p-l-5 p-r-5 text-center" value="02" />
												</div>
												<div class="col-2 text-center">
													<div class="text-muted p-t-5 m-t-2">/</div>
												</div>
												<div class="col-5">
													<input type="text" name="yy" placeholder="YY" class="form-control required p-l-5 p-r-5 text-center" value="26" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">CSC <span class="text-danger">*</span></label>
									<div class="col-md-8">
										<div class="width-100 pull-left m-r-10">
											<input type="text" name="number" placeholder="" class="form-control required p-l-5 p-r-5 text-center" value="123" />
										</div>
									</div>
								</div>
							</div>
						</div>
						</fieldset>
					</div>
				</div>
				</fieldset>
		</div>
	</div>
</div>
</form>
</div>

</div>
</div>


<?php include('includes/footer.php'); ?>