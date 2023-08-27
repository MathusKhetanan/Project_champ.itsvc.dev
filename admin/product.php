<?php
include('../config.php');
include('includes/authentication.php');
include('includes/header.php');

$admin_id = $_SESSION['admin_id'];
$admin_id = 13;
$sql = "SELECT * FROM product 
        LEFT JOIN categories ON product.category_id = categories.category_id
        LEFT JOIN brands ON product.brand_id = brands.brand_id 
        WHERE product.admin_id = $admin_id";
$result = $conn->query($sql);

?>
<div id="content" class="content">
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="./">หน้าหลัก</a></li>
        <li class="breadcrumb-item active">จัดการสินค้า</li>
    </ol>

    <h1 class="page-header">
        จัดการสินค้า
    </h1>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">จัดการสินค้า</h4>
            <div class="btn-group">
                <a href="product.add.php" class="btn btn-success btn-xs">เพิ่มข้อมูลสินค้า</a>
            </div>
        </div>
        <div class="panel-body" style="overflow-y: scroll;">
            <table id="data-table-default" class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-nowrap">ลําดับ</th>
                        <th class="text-nowrap">รูปสินค้า</th>
                        <th class="text-nowrap">ชื่อสินค้า</th>
                        <th class="text-nowrap">แบรนด์</th>
                        <th class="text-nowrap">ประเภทสินค้า</th>
                        <th width="15rem" class="text-nowrap">รายละเอียดสินค้า</th>
                        <th class="text-nowrap">ราคาสินค้า</th>
                        <th class="text-nowrap">จำนวนสินค้า</th>
                        <th class="text-nowrap">ระยะเวลาการใช้ </th>
                        <th class="text-nowrap text-center">ตัวเลือก</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $key => $row) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><img src="../<?php echo $row['product_image']; ?>" class="img-rounded height-30"onError="this.src='https://media.discordapp.net/attachments/1128198864629940244/1144291779957510274/istockphoto-1221460403-170667a_prev_ui.png?width=473&height=473'"/></td>
                            <td><b><?php echo $row['product_name']; ?></b></td>

                            <td><?php echo $row['brand_name']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td>
                                <div class="ellipsis-3" style="width: 10rem;"><?php echo $row['product_detail']; ?></div>
                            </td>
                            <td><?php echo $row['product_price']; ?></td>
                            <td><?php echo $row['product_qty']; ?></td>
                            <td><?php echo $row['product_use']; ?></td>

                            <td class="text-center">
                                <a class="btn btn-warning" href="product.edit.php?id=<?php echo $row['product_id']; ?>">แก้ไข</a>
                                <a class="btn btn-danger" onclick="confirmDelete('<?php echo $row['product_id']; ?>')">ลบ</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>


</div>


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: "ยืนยันการลบข้อมูล",
            text: "คุณต้องการลบข้อมูลสินค้านี้หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = `process_product.delete.php?id=${id}&action=delete`;
            }
        });
    }
</script>

<?php include('includes/footer.php'); ?>