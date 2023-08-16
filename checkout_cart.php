<?php 
			include('config.php'); 
			include('includes/authentication.php'); 
			include('includes/header.php'); 
		?>
	
		<style>
			.sw-main.sw-theme-default .step-anchor {
				background: #343a40;
			}
			.sw-main.sw-theme-default .step-anchor>li.active {
				background: #303030!important;
			}
			.sw-theme-default > ul.step-anchor > li.done > a {
				color: #6f8293!important;
			}
			.sw-main.sw-theme-default .step-anchor>li.done>a .number:before {
				background: #d5dbe0!important;
				color: #4d353c!important;
			}
			.nav.nav-tabs .nav-item .nav-link:hover{
				color: #fff;
			}
			.sw-main.sw-theme-default .sw-toolbar {
				background: #dee2e6;
			}
			.sw-theme-default .sw-toolbar-bottom {
				padding: 1.5625rem 1.875rem!important;
			}
			.btn-group, .btn-group-vertical {
				display: block;
			}
			.sw-btn-prev {
				color: #212529!important;
				background-color: #fff!important;
				border-color: #fff!important;
				-webkit-box-shadow: 0!important;
				box-shadow: 0!important;
			}
			.sw-btn-prev, .sw-btn-next {
				width: 12.5rem!important;

				font-size: 1rem;

				color: #fff;
				background-color: #2d353c;
				border-color: #2d353c;

				padding: .75rem 1.875rem;
				font-weight: 700;
				-webkit-border-radius: 6px;
				border-radius: 6px;
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
													<!-- <thead id="cart-head">
														<tr>
															<th>ร้าน(ABC) ชื่อสินค้า</th>
															<th class="text-center">ราคา</th>
															<th class="text-center">จำนวน</th>
															<th class="text-center">รวม</th>
														</tr>
													</thead>
													<tbody id="cart-item">
														<tr>
															<td class="cart-product">
																<div class="product-img">
																	<img src="dist/img/product/product-iphone-6s-plus.png" alt="" />
																</div>
																<div class="product-info">
																	<div class="title">iPhone 6s Plus 16GB (Silver)</div>
																	<div class="desc">Delivers Tue 26/04/2016 - Free</div>
																</div>
															</td>
															<td class="cart-price text-center">$999.00</td>
															<td class="cart-qty text-center">
																<div class="cart-qty-input">
																	<a href="#" class="qty-control left disabled" data-click="decrease-qty" data-target="#qty"><i class="fa fa-minus"></i></a>
																	<input type="text" name="qty" value="1" class="form-control" id="qty" />
																	<a href="#" class="qty-control right disabled" data-click="increase-qty" data-target="#qty"><i class="fa fa-plus"></i></a>
																</div>
																<div class="qty-desc">1 to max order</div>
															</td>
															<td class="cart-total text-center">
																$999.00
															</td>
														</tr>

														<tr>
															<td class="cart-summary" colspan="4">
																<div class="summary-container">
																	<div class="summary-row">
																		<div class="field">Cart Subtotal</div>
																		<div class="value">$999.00</div>
																	</div>
																	<div class="summary-row text-danger">
																		<div class="field">Free Shipping</div>
																		<div class="value">$0.00</div>
																	</div>
																	<div class="summary-row total">
																		<div class="field">Total</div>
																		<div class="value">$999.00</div>
																	</div>
																</div>
															</td>
														</tr>
													</tbody> -->
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
													<input type="text" placeholder="ชื่อ-สกุล" name="user_fullname" data-parsley-group="step-2" class="form-control" data-parsley-required="true" value="<?php echo $_SESSION['user_fullname']; ?>" readonly/>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-form-label col-md-4 text-lg-right">
												ที่อยู่ <span class="text-danger">*</span>
												</label>
												<div class="col-md-4">
													<textarea name="user_address" placeholder="ที่อยู่" class="form-control" data-parsley-group="step-2" data-parsley-required="true" rows="3" readonly><?php echo $_SESSION['user_address']; ?></textarea>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-form-label col-md-4 text-lg-right">
												เบอร์ติดต่อ <span class="text-danger">*</span>
												</label>
												<div class="col-md-4">
													<input type="text" name="user_tel" placeholder="เบอร์ติดต่อ" class="form-control" data-parsley-group="step-2" data-parsley-required="true" value="<?php echo $_SESSION['user_tel']; ?>" readonly />
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
									<!-- begin fieldset -->
									<fieldset>
										<!-- BEGIN checkout-body -->
										<div class="checkout-body">
											<!-- <h4 class="checkout-title">Choose a payment method</h4> -->
											<div class="form-group row">
												<label class="col-md-4 col-form-label text-lg-right">ชื่อบนบัตร <span class="text-danger">*</span></label>
												<div class="col-md-4">
													<input type="text" class="form-control required" name="cardHolder" placeholder="" value="TEST"/>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-4 col-form-label text-lg-right">หมายเลขบัตร <span class="text-danger">*</span></label>
												<div class="col-md-4">
													<input type="text" class="form-control required" name="cardNumber" placeholder="" value="4242424242424242"/>
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
													<!-- <a href="#" class="text-muted f-s-12 pull-left m-t-5 p-t-2"><i class="fa fa-question-circle"></i> What's this?</a> -->
												</div>
											</div>
										</div>
										<!-- END checkout-body -->
									</fieldset>
									<!-- end fieldset -->
								</div>
								<!-- end step-3 -->
								<!-- begin step-4 -->
								<div id="step-4">
									<fieldset>
										<!-- BEGIN checkout-body -->
										<div class="checkout-body">
											<!-- BEGIN checkout-message -->
											<div class="checkout-message">
												<h1>Thank you! <small>Your Payment has been successfully processed with the following details.</small></h1>
												<div class="table-responsive2">
													<table class="table table-payment-summary">
														<tbody>
															<tr>
																<td class="field">Transaction Status</td>
																<td class="value">Success</td>
															</tr>
															<tr>
																<td class="field">Transaction Reference No.</td>
																<td class="value">REF000001</td>
															</tr>
															<tr>
																<td class="field">Bank Authorised Code</td>
																<td class="value">AUTH000001</td>
															</tr>
															<tr>
																<td class="field">Transaction Date and Time</td>
																<td class="value">05 APR 2016 07:30PM</td>
															</tr>
															<tr>
																<td class="field">Orders</td>
																<td class="value product-summary">
																	<div class="product-summary-img">
																		<img src="dist/img/product/product-iphone-6s-plus.png" alt="" />
																	</div>
																	<div class="product-summary-info">
																		<div class="title">iPhone 6s Plus 16GB (Silver)</div>
																		<div class="desc">Delivers Tue 26/04/2016 - Free</div>
																	</div>
																</td>
															</tr>
															<tr>
																<td class="field">Payment Amount (RM)</td>
																<td class="value">$999.00</td>
															</tr>
														</tbody>
													</table>
												</div>
												<p class="text-silver-darker text-center m-b-0">Should you require any assistance, you can get in touch with Support Team at (123) 456-7890</p>
											</div>
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