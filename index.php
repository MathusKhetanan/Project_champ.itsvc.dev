<?php
include('config.php');
include('includes/header.php');

$sql = "SELECT *,(SELECT SUM(order_qty) FROM order_detail WHERE order_detail.product_id = product.product_id) as topSell FROM product WHERE product_qty > 0 ORDER BY topSell DESC LIMIT 6";
$resultTrending = $conn->query($sql);

$sql = "SELECT * FROM brands";
$resultBrands = $conn->query($sql);
?>

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

    .carousel-item {
        height: 1vh;
        /* เพิ่มความสูงของสไลด์เพื่อรองรับรูปภาพ */
        min-height: 300px;
    }

    .carousel-item img {
        object-fit: cover;
        /* ขยายภาพให้เต็มขนาดในช่วงที่เลือก */
        object-position: center;
        /* ตั้งภาพให้อยู่ตรงกลางแนวดิ่งและนอน */
        height: 100%;
        /* ให้รูปภาพเต็มขนาดในสไลด์ */
        width: 100%;
        /* ให้รูปภาพเต็มขนาดในสไลด์ */
    }

    .carousel-caption {
        bottom: 50%;
        /* ตั้งค่าตำแหน่งต่ำสุดของ caption ให้อยู่ตรงกลาง */
        transform: translateY(50%);
        /* ย้าย caption ขึ้นมาให้อยู่กึ่งกลางแนวดิ่ง */
        text-align: center;
        /* จัดข้อความกึ่งกลางตามแนวนอน */
    }
</style>


<!-- BEGIN #slider -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="https://media.discordapp.net/attachments/1129059372547453119/1135853558374350989/364191257_294062203286926_8749713967569930872_n.png?width=1025&height=320" alt="">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="https://media.discordapp.net/attachments/1129059372547453119/1135853558374350989/364191257_294062203286926_8749713967569930872_n.png?width=1025&height=320" alt="">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="https://media.discordapp.net/attachments/1129059372547453119/1135853558374350989/364191257_294062203286926_8749713967569930872_n.png?width=1025&height=320" alt="">
        </div>
    </div>
</div>
<!-- BEGIN #trending-items -->
<div id="trending-items" class="section-container">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN section-title -->
        <h4 class="section-title clearfix">
            <a href="product.php" class="pull-right">แสดงสินค้าทั้งหมด</a>
            รายการสินค้าที่ได้รับความนิยม
        </h4>
        <!-- END section-title -->
        <!-- BEGIN row -->
        <div class="row row-space-10">
            <?php foreach ($resultTrending as $item) { ?>
                <!-- BEGIN col-2 -->
                <div class="col-lg-2 col-md-4">
                    <!-- BEGIN item -->
                    <div class="item item-thumbnail">
                        <a href="product_detail.php?id=<?php echo $item['product_id']; ?>" class="item-link">
                            <img src="<?php echo $item['product_image']; ?>" />
                            <div class="item-info">
                                <h4 class="item-title"><?php echo $item['product_name']; ?></h4>
                                <p class="item-desc"> <?php echo substr($item['product_detail'], 0, 100); ?></p>
                                <div class="item-price"><?php echo number_format($item['product_price'], 2, '.', ','); ?> ฿
                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- END item -->
                </div>
                <!-- END col-2 -->
            <?php } ?>
        </div>
        <!-- END row -->
    </div>
    <!-- END container -->
</div>
<!-- END #trending-items -->

<?php
foreach ($resultBrands as $row) {
    $sql = "SELECT *,(SELECT SUM(order_qty) FROM order_detail WHERE order_detail.product_id = product.product_id) as topSell FROM product WHERE brand_id = " . $row['brand_id'] . "  ORDER BY topSell DESC LIMIT 6";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
        <!-- BEGIN #trending-items -->
        <div id="trending-items" class="section-container">
            <!-- BEGIN container -->
            <div class="container">
                <!-- BEGIN section-title -->
                <h4 class="section-title clearfix">
                    <a href="product.php?brand=<?php echo $row['brand_id']; ?>" class="pull-right">แสดงสินค้าทั้งหมด</a>
                    <?php echo $row['brand_name']; ?>
                </h4>
                <div class="row row-space-12">
                    <?php foreach ($resultTrending as $item) { ?>
                        <div class="col-lg-2 col-md-4">
                            <!-- BEGIN item -->
                            <div class="item item-thumbnail">
                                <a href="product_detail.php?id=<?php echo $item['product_id']; ?>" class="item-link">
                                    <img src="<?php echo $item['product_image']; ?>" />
                                    <div class="item-info">
                                        <h4 class="item-title"><?php echo $item['product_name']; ?></h4>
                                        <p class="item-desc"> <?php echo substr($item['product_detail'], 0, 100); ?></p>
                                        <div class="item-price"><?php echo number_format($item['product_price'], 2, '.', ','); ?> ฿
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- END item -->
                        </div>
                        <!-- END col-2 -->
                    <?php } ?>
                </div>
                <!-- END row -->
            </div>
            <!-- END container -->
        </div>
        <!-- END #trending-items -->

        </div>
        </div>
        <!-- END item -->
        </div>
        <!-- END col-2 -->
<?php }
} ?>
</div><!-- END row -->
</div>

<!-- END #trending-items -->


<?php include('includes/footer.php'); ?>