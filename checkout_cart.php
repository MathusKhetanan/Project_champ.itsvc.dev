	<?php
	include('config.php');
	include('includes/authentication.php');
	include('includes/header.php');
	$sql = "SELECT * FROM `tbl_bank`";


	$result = $conn->query($sql);
	?>

	<style>
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
	</style>

	<!-- BEGIN #checkout-cart -->
	<div class="section-container" id="checkout-cart">
		<!-- BEGIN container -->
		<div class="container">
			<!-- BEGIN checkout -->
			<div class="checkout">
				<!-- begin wizard-form -->
				<form action="process_checkout.php" method="POST" name="form-wizard" class="form-control-with-bg">
					<input type="hidden" name="amount">
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
							<!-- begin step-3 -->
							<div id="step-3">
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">เลือกธนาคาร: <span class="text-danger">*</span></label>
									<div class="col-md-4">
										<select class="form-control" id="bank" name="bank">
											<?php
											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo '<option value="' . $row['id'] . '">' . $row['b_name'] . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">จำนวนเงิน <span class="text-danger">*</span></label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="amount" data-parsley-group="step-3"  required title="กรุณากรอกจำนวนเงินที่โอนให้ตรงกับราคาสินค้า" />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-4 col-form-label text-lg-right">แนบสลิป <span class="text-danger">*</span></label>
									<div class="col-md-4">
										<input type="file" class="form-control-file" name="slip" accept=".pdf,.jpg,.png"/>
									</div>
								</div>
							</div>












							<div id="hidden-step-3" style="display: none;">
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

							<!-- END checkout-body -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-3 -->


						<!-- begin step-4 -->

						<!-- END checkout-message -->
					</div>
					<!-- END checkout-body -->
					</fieldset>
			</div>
			<!-- end step-4 -->
		</div>
		<!-- end wizard-content -->
	</div>
	<!-- end wizard -->
	</form>
	<!-- end wizard-form -->
	</div>
	<!-- END checkout -->

	</div>
	<!-- END container -->
	</div>
	<!-- END #checkout-cart -->

	<?php include('includes/footer.php'); ?>
</body>

</html>