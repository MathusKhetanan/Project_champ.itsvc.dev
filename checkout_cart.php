        <?php
        include('config.php');
        include('includes/authentication.php');
        include('includes/header.php');

        // ดึงข้อมูลธนาคาร
        $sql_bank = "SELECT * FROM tbl_bank";
        $result_bank = $conn->query($sql_bank);

        // ดึงข้อมูลสินค้า
        $sql_product = "SELECT * FROM product";
        $result_products = $conn->query($sql_product);
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
                                    <!-- Begin fieldset -->
                                    <fieldset>
                                        <!-- Begin checkout-body -->
                                        <div class="checkout-body">
                                            <!-- Product Selection -->
                                            <div class="form-group row">
                        <label class="col-form-label col-md-4 text-lg-right">เลือกสินค้า <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                        <select class="default-select2 form-control" id="product_id" name="product_id" data-parsley-required="true">
            <option value="">-- เลือกสินค้า --</option>
            <?php while ($row_product = $result_products->fetch_assoc()) { ?>
                <option value="<?php echo $row_product['product_id']; ?>">
                    <?php echo $row_product['product_name']; ?>
                </option>
            <?php } ?>
        </select>   
                        </div>


                        
                    </div>




                    <!-- Bank Selection -->
                    <div class="form-group row">
                        <label class="col-form-label col-md-4 text-lg-right">ธนาคารที่โอนเข้า <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <select class="default-select2 form-control" id="brand_id" name="id" data-parsley-required="true">
                                <option value="">-- เลือกธนาคาร --</option>
                                <?php while ($row_bank = $result_bank->fetch_assoc()) { ?>
                                    <option value="<?php echo $row_bank['id']; ?>">
                                        <?php echo $row_bank['b_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                                            <form method="post" action="process_form.php">
                                                <div class="form-group row">
                                                    <label class="col-md-4 col-form-label text-lg-right">ข้อมูลธนาคารเลขบัญขี</label>
                                                    <div class="col-md-4">
                                                        <textarea name="text" class="form-control" rows="3" readonly>ชื่อธนาคาร: ธนาคารกรุงไทย                                         ชื่อเจ้าของบัญชีธนาคาร: นายอดิศักดิ์ อิ่มสุขศิลป์                  เลขที่บัญชี: 827-0-35966-1</textarea>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Amount -->
                                            <!-- Amount -->
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-lg-right">จำนวนเงิน <span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="amount" data-parsley-group="step-3" placeholder="โปรดกรอกจำนวนเงินที่โอนให้ตรงกับราคาสินค้า" value="" required />
                                                </div>
                                            </div>

                                            <!-- Payment Date -->
                                            <div class="form-group row">
                                                <label class="col-md-4 col-form-label text-lg-right">วันที่และเวลาชำระเงิน <span class="text-danger">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="datetime-local" name="payment_date" class="form-control required" data-parsley-group="step-3" />
                                                </div>
                                            </div>
                                            <!-- End checkout-body -->
                                    </fieldset>

                                    <!-- end fieldset -->
                                </div>
                                <!-- end step-3 -->
                                <!-- begin step-4 -->

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