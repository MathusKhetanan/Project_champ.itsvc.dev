<?php
include('config.php');
include('includes/header.php');

$sql = "SELECT * FROM product LEFT JOIN brands ON product.brand_id = brands.brand_id LEFT JOIN categories ON product.category_id = categories.category_id LEFT JOIN seller ON product.seller_id = seller.seller_id WHERE product_id = " . $conn->real_escape_string($_GET['id']) . " AND product_status = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sql = "SELECT * FROM product WHERE category_id = " . $row['category_id'] . " AND product_status = 1 LIMIT 6";
$result = $conn->query($sql);

$sql = "SELECT * FROM product_review LEFT JOIN user ON product_review.user_id = user.user_id WHERE product_id = " . $row['product_id'];
$resultReview = $conn->query($sql);
?>

<!-- BEGIN #product -->
<div id="product" class="section-container p-t-20">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN breadcrumb -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
            <li class="breadcrumb-item"><a href="product.php?category=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a>
            </li>
            <li class="breadcrumb-item"><a href="product.php?brand=<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></a>
            </li>
            <li class="breadcrumb-item active"><?php echo $row['product_name']; ?></li>
        </ul>
        <!-- END breadcrumb -->
        <!-- BEGIN product -->
        <div class="product">
            <!-- BEGIN product-detail -->
            <div class="product-detail">
                <!-- BEGIN product-image -->
                <div class="product-image">
                    <!-- BEGIN product-main-image -->
                    <div class="product-main-image" data-id="main-image">
                        <img src="<?php echo $row['product_image']; ?>" onError="this.src='https://thaigifts.or.th/wp-content/uploads/2017/03/no-image.jpg'" />
                    </div>
                    <!-- END product-main-image -->
                </div>
                <!-- END product-image -->
                <!-- BEGIN product-info -->
                <div class="product-info">
                    <!-- BEGIN product-info-header -->
                    <div class="product-info-header">
                        <h1 class="product-title">
                            <!-- <span class="badge bg-primary">41% OFF</span>  -->
                            <?php echo $row['product_name']; ?>
                        </h1>
                        <ul class="product-category">
                            <li>ร้าน: <a href="product.php?shop=<?php echo $row['seller_id']; ?>"><?php echo $row['seller_shop']; ?></a>
                            </li>
                            <li>/</li>
                            <li>ประเภท: <a href="product.php?category=<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></a>
                            </li>
                            <li>/</li>
                            <li>แบรนด์: <a href="product.php?brand=<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></a>
                            </li>
                        </ul>
                    </div>
                    <!-- END product-warranty -->
                    <!-- BEGIN product-info-list -->

                    <style>
                        .product-info-list li {
                            position: relative;
                            padding-left: 1.5em;
                            /* ปรับขนาดให้สัญลักษณ์วงกลมอยู่บนข้อความบนสุด */
                        }

                        .product-info-list li::before {
                            content: "\ ";

                            /* ใส่รหัสของสัญลักษณ์วงกลมจาก Font Awesome */
                            font-family: "Font Awesome Free";
                            /* แทนที่ชื่อ Font Awesome ของคุณให้ตรงกับชื่อใน CSS */
                            position: absolute;
                            top: 0.4em;
                            /* ปรับตำแหน่งให้สัญลักษณ์วงกลมอยู่บนข้อความบนสุด */
                            left: 0.5em;
                            /* ปรับสีของสัญลักษณ์วงกลม (สีของเส้น) ใส่สีที่คุณต้องการ */
                            background-color: #52b5ff;
                            /* ปรับสีพื้นหลังของสัญลักษณ์วงกลม ใส่สีที่คุณต้องการ */
                            border-radius: 50%;
                            /* กำหนดให้มีรูปร่างเป็นวงกลม */
                            width: 1em;
                            /* กำหนดขนาดกว้างของสัญลักษณ์วงกลม */
                            height: 1em;
                            /* กำหนดขนาดสูงของสัญลักษณ์วงกลม */
                            text-align: center;
                            line-height: 1em;
                        }
                    </style>
                    <ul class="product-info-list">
                        <li><?php echo $row['product_detail']; ?></li>
                    </ul>


                    <!-- END product-info-list -->
                    <!-- BEGIN product-purchase-container -->
                    <div class="product-purchase-container">
                        <div class="product-discount">
                        </div>
                        <div class="product-price">
                            <div class="price"><?php echo number_format($row['product_price'], 2, '.', ','); ?> ฿</div>
                        </div>
                        <?php if ($row['product_qty'] <= 0) { ?>
                            <button class="btn btn-inverse btn-theme btn-lg width-200" disabled>สินค้าหมด</button>
                        <?php } elseif (!isset($_SESSION['user_id'])) { ?>
                            <button class="btn btn-inverse btn-theme btn-lg width-200" onclick="redirectToLogin()">เพิ่มลงในตะกร้า</button>
                        <?php } else { ?>
                            <button class="btn btn-inverse btn-theme btn-lg width-200" onclick="addCart(<?php echo $row['seller_id']; ?>,'<?php echo $row['seller_shop']; ?>',<?php echo $row['product_id']; ?>, '<?php echo $row['product_name']; ?>', <?php echo $row['product_price']; ?>, '<?php echo $row['product_image']; ?>')">เพิ่มลงในตะกร้า</button>
                        <?php } ?>

                        <script>
                            function redirectToLogin() {
                                window.location.href = "login.php"; // Replace "login.php" with the actual login page URL
                            }
                        </script>
                    </div>
                </div>
            </div>
            <!-- END product-detail -->
            <!-- BEGIN product-tab -->
            <div class="product-tab">
                <!-- BEGIN #product-tab -->
                <ul id="product-tab" class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#product-reviews" data-toggle="tab">รีวิวสินค้า (<?php echo $resultReview->num_rows; ?>)</a></li>
                </ul>
                <!-- END #product-tab -->
                <!-- BEGIN #product-tab-content -->
                <div id="product-tab-content" class="tab-content">
                    <!-- BEGIN #product-desc -->
                    <div class="tab-pane fade" id="product-desc">
                        <!-- BEGIN product-desc -->
                        <!-- END product-desc -->
                        <!-- BEGIN product-desc -->
                        <div class="product-desc">
                            <div class="image">
                            </div>
                            <div class="desc">
                            </div>
                        </div>
                        <!-- END product-desc -->
                    </div>
                    <!-- END #product-desc -->
                    <!-- BEGIN #product-info -->
                    <div class="tab-pane fade" id="product-info">
                        <!-- BEGIN table-responsive -->
                        <div class="table-responsive">
                            <!-- BEGIN table-product -->
                            <table class="table table-product table-striped">
                            </table>
                            <!-- END table-product -->
                        </div>
                        <!-- END table-responsive -->
                    </div>
                    <!-- END #product-info -->
                    <!-- BEGIN #product-reviews -->
                    <div class="tab-pane active show fade" id="product-reviews">
                        <!-- BEGIN row -->
                        <div class="row row-space-30">
                            <?php foreach ($resultReview as $key => $review) { ?>
                                <!-- BEGIN col-7 -->
                                <div class="col-md-7 mb-4 mb-lg-0">
                                    <!-- BEGIN review -->
                                    <div class="review" style=" padding: 1rem; border-bottom: <?php echo ($key + 1 == $resultReview->num_rows) ? "0" : "1"; ?>px solid #dee2e6;">
                                        <div class="review-info">
                                            <div class="review-icon"><img src="dist/img/logo/icon.png" alt="" /></div>
                                            <div class="review-rate">
                                            </div>
                                            <div class="review-name"><?php echo $review['user_fullname']; ?></div>
                                            <div class="review-date"><?php echo $review['createdAt']; ?></div>
                                        </div>
                                        <div class="review-title">
                                            <?php echo $review['review_title']; ?>
                                        </div>
                                        <div class="review-message">
                                            <?php echo $review['review_message']; ?>
                                        </div>
                                    </div>
                                    <!-- END review -->
                                </div>
                                <!-- END col-7 -->
                            <?php } ?>
                            <!-- BEGIN col-5 -->
                            <div class="col-md-5">
                                <!-- BEGIN review-form -->
                                <?php if (isset($_POST['order_id'])) { ?>
                                    <div class="review-form">
                                        <form action="process_review.php" name="review_form" method="POST" data-parsley-validate="true">
                                            <h2>เขียนรีวิวสินค้า</h2>
                                            <div class="form-group">
                                                <label for="name">ชื่อ <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" data-parsley-required="true" value="<?php echo $_SESSION['user_fullname']; ?>" readonly />
                                            </div>
                                            <div class="form-group">
                                                <label for="review_title">หัวข้อ <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="review_title" name="review_title" data-parsley-required="true" />
                                            </div>
                                            <div class="form-group">
                                                <label for="review_message">เขียนรีวิว <span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="8" id="review_message" name="review_message" data-parsley-required="true"></textarea>
                                            </div>
                                            <input type="hidden" name="order_id" value="<?php echo $_POST['order_id']; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            <button type="submit" class="btn btn-inverse btn-theme btn-lg">เขียนรีวิวสินค้าเลย</button>
                                        </form>
                                    </div>
                                <?php } ?>
                                <!-- END review-form -->
                            </div>
                            <!-- END col-5 -->
                        </div>
                        <!-- END row -->
                    </div>
                    <!-- END #product-reviews -->
                </div>
                <!-- END #product-tab-content -->
            </div>
            <!-- END product-tab -->
        </div>
        <style>
            .item-thumbnail img {
                max-width: 100%;
                height: auto;
            }

            .item-thumbnail {
                border: 1px solid #ccc;
                padding: 10px;
                border-radius: 5px;
            }

            .item-thumbnail:hover {
                border-color: #999;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            }
        </style>

        <!-- END product -->
        <?php if ($result->num_rows > 0) { ?>
            <!-- BEGIN similar-product -->
            <h4 class="m-b-15 m-t-30">สินค้าที่คุณอาจจะสนใจ</h4>
            <div class="row row-space-10">
                <?php foreach ($result as $item) { ?>
                    <div class="col-lg-2 col-md-4">
                        <!-- BEGIN item -->
                        <div class="item item-thumbnail">
                            <a href="product_detail.php?id=<?php echo $item['product_id']; ?>" class="item-link">
                                <img src="<?php echo $item['product_image']; ?>"/>
                                <div class="item-info">
                                    <h4 class="item-title"><?php echo $item['product_name']; ?></h4>
                                    <p class="item-desc"> <?php echo substr($item['product_detail'], 0, 100); ?></p>
                                    <div class="item-price"><?php echo number_format($item['product_price'], 2, '.', ','); ?> ฿</div>

                                </div>
                            </a>
                        </div>
                        <!-- END item -->
                    </div>
            <?php }
            } ?>
            </div>
            <!-- END row -->
    </div>
    <!-- END container -->
</div>

<?php include('includes/footer.php'); ?>