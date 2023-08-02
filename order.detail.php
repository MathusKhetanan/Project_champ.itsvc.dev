		<?php 
      include('config.php');
			include('includes/authentication.php'); 
			include('includes/header.php'); 

			$order_id = $conn->real_escape_string($_GET['id']);
      $sql = "SELECT * FROM orders LEFT JOIN user ON orders.user_id = user.user_id LEFT JOIN seller ON orders.seller_id = seller.seller_id WHERE order_id = $order_id AND orders.user_id = ".$_SESSION['user_id'];
      $result = $conn->query($sql);
			$row = $result->fetch_assoc();

			$sql = "SELECT * FROM order_detail WHERE order_id = $order_id";
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
		            <div class="account-body"
		                style="height: 100%;min-height: 650px;background-color: #d9e0e7; overflow: scroll;">
		                <!-- BEGIN row -->
		                <div class="row">
		                    <!-- BEGIN col-6 -->
		                    <div class="col-md-12">
		                        <!-- begin panel -->
		                        <!-- begin invoice -->
		                        <div class="invoice">
		                            <!-- begin invoice-company -->
		                            <div class="invoice-company">
		                                ร้าน: <?php echo $row['seller_shop']; ?>
		                            </div>
		                            <!-- end invoice-company -->
		                            <!-- begin invoice-header -->
		                            <div class="invoice-header">
		                                <div class="invoice-from">
		                                    <small>จาก</small>
		                                    <address class="m-t-5 m-b-5">
		                                        <strong
		                                            class="text-inverse"><?php echo $row['seller_fullname']; ?>.</strong><br />
		                                        <?php echo $row['seller_address']; ?>
		                                    </address>
		                                </div>
		                                <div class="invoice-to">
		                                    <small>ถึง</small>
		                                    <address class="m-t-5 m-b-5">
		                                        <strong
		                                            class="text-inverse"><?php echo $row['user_fullname']; ?></strong><br />
		                                        <?php echo $row['user_address']; ?>
		                                    </address>
		                                </div>
		                                <div class="invoice-date">
		                                    <small>สถานะออเดอร์ / <span
		                                            class="badge bg-<?php echo $StatusColor[$row['order_status']]; ?>"
		                                            style="font-size: 12px"><?php echo $Status[$row['order_status']]; ?></span></small><br />
		                                    หมายเลขพัสดุ: <?php echo $row['order_tracking']; ?>
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
		                                                <th class="text-right" width="20%">รวม</th>
		                                                <th class="text-right" width="20%">ตัวเลือก</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody>
		                                            <?php 
														$total = 0;
														foreach ($result as $key => $item){ 
															$sql2 = "SELECT * FROM product_review WHERE order_id = ".$item['order_id']." AND product_id = ".$item['product_id'];
															$result2 = $conn->query($sql2);
															$total += $item['order_subtotal'];
													?>
		                                            <tr>
		                                                <td>
		                                                    <span
		                                                        class="text-inverse"><?php echo $item['product_name']; ?></span>
		                                                </td>
		                                                <td class="text-center"><?php echo $item['product_price']; ?></td>
		                                                <td class="text-center">x <?php echo $item['order_qty']; ?></td>
		                                                <td class="text-right"><?php echo $item['order_subtotal']; ?></td>
		                                                <td class="text-right">
		                                                    <form
		                                                        action="product_detail.php?id=<?php echo $item['product_id']; ?>"
		                                                        method="post">
		                                                        <button type="submit" class="btn btn-lime" name="order_id"
		                                                            value="<?php echo $item['order_id']; ?>"
		                                                            <?php echo ($row['order_status']!="successful" || $result2->num_rows > 0)?"disabled" :""; ?>>เขียนรีวิว</button>
		                                                    </form>
		                                                </td>
		                                            </tr>
		                                            <?php } ?>
		                                        </tbody>
		                                    </table>
		                                </div>
		                                <!-- end table-responsive -->
		                                <!-- begin invoice-price -->
		                                <div class="invoice-price">
		                                    <div class="invoice-price-right">
		                                        <small>รวมทั้งหมด</small> <span class="f-w-600"><?php echo $total; ?> ฿</span>
		                                    </div>
		                                </div>
		                                <!-- end invoice-price -->
		                            </div>
		                            <!-- end invoice-content -->
		                            <!-- begin invoice-footer -->
		                            <div class="invoice-footer">
		                                <p class="text-center m-b-5 f-w-600">
		                                    ขอบคุณสำหรับการสั่งซื้อ
		                                </p>
		                                <p class="text-center">
		                                    <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> ติดต่อ:
		                                        <?php echo $row['seller_tel']; ?></span>
		                                    <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i>
		                                        <?php echo $row['seller_email']; ?></span>
		                                </p>
		                            </div>
		                            <!-- end invoice-footer -->
		                        </div>
		                        <!-- end invoice -->
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