<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$seller_id = $_SESSION['seller_id'];

// Handle date selection
$date = date('Y-m-01'); // Default to the first day of the current month
if (isset($_GET['date'])) {
    $date = date('Y-m-01', strtotime($_GET['date']));
}

// Define reusable function for calculating discounted amount
function calculateDiscountedAmount($total, $percentage) {
    return $total - ($total * $percentage / 100);
}

// Query for top-selling brands
$sqlBrand = "
    SELECT brands.*, SUM(order_subtotal) AS order_total
    FROM product
    LEFT JOIN brands ON product.brand_id = brands.brand_id
    LEFT JOIN order_detail ON product.product_id = order_detail.product_id
    LEFT JOIN orders ON orders.order_id = order_detail.order_id
    WHERE DATE_FORMAT(order_detail.createdAt, '%Y-%m') = DATE_FORMAT('$date', '%Y-%m')
        AND (SELECT order_status FROM orders WHERE order_id = order_detail.order_id) = 'successful'
        AND product.seller_id = $seller_id
    GROUP BY product.seller_id, product.brand_id
    ORDER BY order_total DESC";
$resultSumOrderTotalBrand = $conn->query($sqlBrand);

// Query for top-selling categories
$sqlCategory = "
    SELECT categories.*, SUM(order_subtotal) AS order_total
    FROM product
    LEFT JOIN categories ON product.category_id = categories.category_id
    LEFT JOIN order_detail ON product.product_id = order_detail.product_id
    LEFT JOIN orders ON orders.order_id = order_detail.order_id
    WHERE DATE_FORMAT(order_detail.createdAt, '%Y-%m') = DATE_FORMAT('$date', '%Y-%m')
        AND (SELECT order_status FROM orders WHERE order_id = order_detail.order_id) = 'successful'
        AND product.seller_id = $seller_id
    GROUP BY product.seller_id, product.category_id
    ORDER BY order_total DESC";
$resultSumOrderTotalCategory = $conn->query($sqlCategory);
?>

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">รายงานยอดขาย</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header mb-5">
        รายงานยอดขาย (ข้อมูลตัวอย่างให้เลือกวันที่เป็นเดือนมีนาคม)
        <form action="#" method="get" class="row mt-2">
            <div class="col-4">
                <input type="date" class="form-control" name="date">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">ค้นหา</button>
            </div>
        </form>
    </h1>
    <!-- end page-header -->

    <div class="row">
        <div class="col-6">
        </div>

        <div class="col-6">
            <!-- begin panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">แบรนด์สินค้าขายดีในเดือนนี้</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table-default-2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="1%"></th>
                                <th width="1%" data-orderable="false"></th>
                                <th class="text-nowrap">ชื่อแบรนด์</th>
                                <th class="text-nowrap">ยอดขายเดือนนี้</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultSumOrderTotalBrand as $key => $row) {
                                $discountedTotal = calculateDiscountedAmount($row['order_total'], $row['order_total_free']);
                            ?>
                            <tr>
                                <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
                                <td width="1%" class="with-img"><img src="../<?php echo $row['brand_image']; ?>" class="img-rounded height-80" onError="this.src='https://thaigifts.or.th/wp-content/uploads/2017/03/no-image.jpg'" /></td>
                                <td><?php echo $row['brand_name']; ?></td>
                                <td><?php echo number_format($discountedTotal, 2); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end panel -->

            <!-- begin panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">ประเภทสินค้าขายดีในเดือนนี้</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table-default-3" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="1%"></th>
                                <th class="text-nowrap">ประเภทสินค้า</th>
                                <th class="text-nowrap">ยอดขายเดือนนี้</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultSumOrderTotalCategory as $key => $row) {
                                $discountedTotal = calculateDiscountedAmount($row['order_total'], $row['order_total_free']);
                            ?>
                            <tr>
                                <td width="1%" class="f-s-600 text-inverse"><?php echo $key + 1; ?></td>
                                <td><?php echo $row['category_name']; ?></td>
                                <td><?php echo number_format($discountedTotal, 2); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>
</div>
<!-- end #content -->

<?php include('includes/footer.php'); ?>
<script>
    $('#data-table-default-2').DataTable();
    $('#data-table-default-3').DataTable();
</script>
