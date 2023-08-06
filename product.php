<?php
include('config.php');
include('includes/header.php');

// brand, category, shop

$sql = "SELECT *,(SELECT SUM(order_qty) FROM order_detail WHERE order_detail.product_id = product.product_id) as topSell FROM product LEFT JOIN brands ON product.brand_id = brands.brand_id LEFT JOIN categories ON product.category_id = categories.category_id LEFT JOIN seller ON product.seller_id = seller.seller_id WHERE 1=1 AND product_qty > 0 AND product_status = 1";
if (isset($_GET['brand']) && $_GET['brand'] !== '') {
    $sql = $sql . " AND product.brand_id = " . $conn->real_escape_string($_GET['brand']);
    $sql2 = "SELECT * FROM brands WHERE brand_id = " . $conn->real_escape_string($_GET['brand']);
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
}
if (isset($_GET['category']) && $_GET['category'] !== '') {
    $sql = $sql . " AND product.category_id = " . $conn->real_escape_string($_GET['category']);
    $sql2 = "SELECT * FROM categories WHERE category_id = " . $conn->real_escape_string($_GET['category']);
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
}
if (isset($_GET['shop']) && $_GET['shop'] !== '') {
    $sql = $sql . " AND product.seller_id = " . $conn->real_escape_string($_GET['shop']);
    $sql2 = "SELECT * FROM seller WHERE seller_id = " . $conn->real_escape_string($_GET['shop']);
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
}
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $sql = $sql . " AND product_name LIKE '%" . $conn->real_escape_string($_GET['q']) . "%'";
}
$sql .= " ORDER BY topSell DESC";
$result = $conn->query($sql);

$sql = "SELECT *,(SELECT count(brand_id) FROM product WHERE brand_id = brands.brand_id)as count FROM brands";
$resultBrands = $conn->query($sql);

$sql = "SELECT *,(SELECT count(category_id) FROM product WHERE category_id = categories.category_id)as count FROM categories";
$resultCategories = $conn->query($sql);
?>
<!-- BEGIN #page-header -->
<div id="page-header" class="section-container page-header-container bg-black">
    <!-- BEGIN page-header-cover -->
    <div class="page-header-cover">
        <img src="dist/img/cover/cover-12.jpg" alt="" />
    </div>
    <!-- END page-header-cover -->
    <!-- BEGIN container -->
    <div class="container">
        <?php if (isset($_GET['q']) && $_GET['q'] !== '') { ?>
            <h1 class="page-header">ผลลัพธ์การค้นหา "<b><?php echo $_GET['q']; ?></b>"</h1>
        <?php } else if (isset($_GET['brand']) && $_GET['brand'] !== '') { ?>
            <h1 class="page-header">ผลลัพธ์การค้นหาแบรนด์ "<b><?php echo $row2['brand_name']; ?></b>"</h1>
        <?php } else if (isset($_GET['category']) && $_GET['category'] !== '') { ?>
            <h1 class="page-header">ผลลัพธ์การค้นหาประเภท "<b><?php echo $row2['category_name']; ?></b>"</h1>
        <?php } else if (isset($_GET['shop']) && $_GET['shop'] !== '') { ?>
            <h1 class="page-header">ผลลัพธ์การค้นหาร้าน "<b><?php echo $row2['seller_shop']; ?></b>"</h1>
        <?php } else { ?>
            <h1 class="page-header"><b>สินค้าทั้งหมด</b></h1>
        <?php } ?>
    </div>
    <!-- END container -->
</div>
<!-- BEGIN #page-header -->

<!-- BEGIN search-results -->
<div id="search-results" class="section-container">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN search-container -->
        <div class="search-container">
            <!-- BEGIN search-content -->
            <div class="search-content">
                <!-- BEGIN search-toolbar -->
                <div class="search-toolbar">
                    <!-- BEGIN row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>
                                พบสินค้าทั้งหมด <?php echo $result->num_rows; ?>
                                รายการ สำหรับ
                                <?php if (isset($_GET['q']) && $_GET['q'] !== '') { ?>
                                    สินค้าชื่อ "<?php echo $_GET['q']; ?>"
                                <?php } else if (isset($_GET['brand']) && $_GET['brand'] !== '') { ?>
                                    แบรนด์ "<?php echo $row2['brand_name']; ?>"
                                <?php } else if (isset($_GET['category']) && $_GET['category'] !== '') { ?>
                                    ประเภท "<?php echo $row2['category_name']; ?>"
                                <?php } else if (isset($_GET['shop']) && $_GET['shop'] !== '') { ?>
                                    ร้าน "<?php echo $row2['seller_shop']; ?>"
                                <?php } else { ?>
                                    "สินค้าทั้งหมด"
                                <?php } ?>
                            </h4>
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
                        <!-- END col-6 -->
                        <!-- BEGIN col-6 -->
                        <div class="col-lg-6 text-right">
                            <ul class="sort-list">
                            </ul>
                        </div>
                        <!-- END col-6 -->
                    </div>
                    <!-- END row -->
                </div>
                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
                <div class="search-item-container">
                    <!-- BEGIN item-row -->
                    <div class="row row-space-10">
                        <?php foreach ($result as $key => $item) { ?>

                            <!-- BEGIN col-2 -->
                            <div class="col-lg-4 col-md-4">
                                <!-- BEGIN item -->
                                <div class="item item-thumbnail">
                                    <a href="product_detail.php?id=<?php echo $item['product_id']; ?>" class="item-link">
                                        <img src="<?php echo $item['product_image']; ?>" onError="this.src='https://thaigifts.or.th/wp-content/uploads/2017/03/no-image.jpg'" />
                                        <div class="item-info">
                                            <h4 class="item-title"><?php echo $item['product_name']; ?></h4>
                                            <p class="item-desc"> <?php echo substr($item['product_detail'], 0, 100); ?></p> 
                                            <div class="item-price"><?php echo $item['product_price']; ?> ฿</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- END item -->
                        <?php } ?>
                    </div>
                    <!-- END item-row -->
                </div>
                <!-- END search-item-container -->
            </div>
            <!-- END search-content -->
            <!-- BEGIN search-sidebar -->
            <div class="search-sidebar">
                <h4 class="title">ตัวกรองสินค้า</h4>
                <form action="product.php" method="GET" name="filter_form">
                    <div class="form-group">
                        <h5 class="control-label">ค้นหาสินค้า</h5>
                        <input type="text" class="form-control input-sm" name="q" placeholder="ป้อนชื่อสินค้า" value="<?php echo (isset($_GET['q']) && $_GET['q'] !== '') ? $_GET['q'] : ""; ?>" />
                    </div>
                    <div class="m-b-30">
                        <button type="submit" class="btn btn-sm btn-theme btn-inverse"><i class="fa fa-search fa-fw mr-1 ml-n3"></i> ค้นหา</button>
                    </div>
                </form>
                <h4 class="title m-b-0">แบรนด์สินค้า</h4>
                <ul class="search-category-list">
                    <?php foreach ($resultBrands as $item) { ?>
                        <li><a href="<?php echo ($item['count'] == 0) ? "#" : "product.php?brand=" . $item['brand_id']; ?>"><?php echo $item['brand_name']; ?>
                                <span class="pull-right">(<?php echo $item['count']; ?>)</span></a></li>
                    <?php } ?>
                </ul>
                <h4 class="title m-t-10">ประเภทสินค้า</h4>
                <ul class="search-category-list">
                    <?php foreach ($resultCategories as $item) { ?>
                        <li><a href="<?php echo ($item['count'] == 0) ? "#" : "product.php?category=" . $item['category_id']; ?>"><?php echo $item['category_name']; ?>
                                <span class="pull-right">(<?php echo $item['count']; ?>)</span></a></li>
                    <?php } ?>
                </ul>
            </div>
            <!-- END search-sidebar -->
        </div>
        <!-- END search-container -->
    </div>
    <!-- END container -->
</div>
<!-- END search-results -->

<?php include('includes/footer.php'); ?>