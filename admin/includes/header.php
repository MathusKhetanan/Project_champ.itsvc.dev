<?php 
	if(!isset($_SESSION)){
		session_start();
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="https://media.discordapp.net/attachments/1128198864629940244/1128967842545545287/logo.png">
    <title>ร้านค้าขายเครื่องกรองนํ้า A & P | ผู้ดูแลระบบ</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- ================== BEGIN BASE CSS STYLE ================== -->

    <link href="../dist/css/default/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="../dist/plugins/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" />

    <link href="../dist/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.20/dataTables.bootstrap4.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.1/responsive.bootstrap4.min.css"
        rel="stylesheet" />

    <!-- ================== END PAGE LEVEL CSS STYLE ================== -->
    <style>
    /* table tbody tr td {
			padding: 5px!important;
		} */
    textarea {
        resize: none;
    }

    .ellipsis-1,
    .ellipsis-1 * {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }

    .ellipsis-3,
    .ellipsis-3 * {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .ellipsis-4,
    .ellipsis-4 * {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
    }
/* สำหรับตารางที่ต้องการกำหนดขนาดความกว้างคอลัมน์ */
.table-fixed {
    table-layout: fixed;
}

/* สำหรับแถบที่ต้องการเลื่อนแนวนอนเมื่อขนาดตารางเกินหน้าจอ */
.table-responsive {
    overflow-x: auto;
}

    </style>
</head>

<!-- begin #page-loader -->
<div id="page-loader" class="fade show">
    <span class="spinner"></span>
</div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container"
    class="page-container fade page-sidebar-fixed page-header-fixed page-with-light-sidebar page-with-wide-sidebar">
    <!-- begin #header -->
    <div id="header" class="header navbar-default">
        <!-- begin navbar-header -->
        <div class="navbar-header">
            <a href="index.php" class="navbar-brand"><img
                    src="https://media.discordapp.net/attachments/1128198864629940244/1128967842545545287/logo.png"
                    class="ml-2 mr-3" <span class="text-primary">C</span>hamp <span class="text-primary"><span
                        class="text-primary">S</span>hop</span></a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end navbar-header -->
        <!-- begin header-nav -->
        <ul class="navbar-nav navbar-right">
            <li class="dropdown navbar-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="https://media.discordapp.net/attachments/1128198864629940244/1128955900594495488/istockphoto-1300845620-612x612.png?width=473&height=473"
                        class="user-img" alt="" />
                    <span class="d-none d-md-inline"><?php echo $_SESSION['seller_fullname']; ?></span> <b
                        class="caret"></b>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="profile.php" class="dropdown-item">แก้ไขข้อมูลส่วนตัว</a>
                    <a href="withdraw.php" class="dropdown-item">จัดการถอนเงิน</a>

                    <a href="../index.php" class="dropdown-item">ดูหน้าบ้าน</a>
                    <div class="dropdown-divider"></div>
                    <a href="../logout.php" class="dropdown-item">ออกจากระบบ</a>
                </div>
            </li>
        </ul>
        <!-- end header-nav -->
    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
        <!-- begin sidebar scrollbar -->
        <div data-scrollbar="true" data-height="100%">
            <!-- begin sidebar user -->
            <ul class="nav">
                <li class="nav-profile">
                    <a href="javascript:;" data-toggle="nav-profile">
                        <div class="cover with-shadow"></div>
                        <div class="image mx-auto">
                            <img src="https://media.discordapp.net/attachments/1128198864629940244/1128955900594495488/istockphoto-1300845620-612x612.png?width=473&height=473"
                                alt="" />
                        </div>
                        <div class="info text-center">
                            <!-- <b class="caret pull-right"></b> -->
                            <?php echo $_SESSION['seller_fullname']; ?>
                            <small>ผู้ดูแลระบบ<br />บริษัทขายเครื่องกรองนํ้า A & P</small>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- end sidebar user -->
            <!-- begin sidebar nav -->
            <ul class="nav">
                <li class="nav-header">ร้านค้า</li>

                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["index", "seller"]))? "active": ""; ?>">
                    <a href="index.php">
                        <i class="icon-screen-desktop"></i>
                        <span>รายงานยอดขาย</span>
                    </a>
                </li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["brands", "brand.add", "brand.edit"])) ? "active" : ""; ?>">
                    <a href="brands.php">
                        <i class="icon-handbag"></i>
                        <span>จัดการแบรนด์</span>
                    </a>
                </li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["categories", "category.add", "category.edit"]))? "active": ""; ?>">
                    <a href="categories.php">
                        <i class="icon-tag"></i>
                        <span>จัดการประเภทสินค้า</span>
                    </a>
                </li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["product", "product.add", "product.edit"]))? "active": ""; ?>">
                    <a href="product.php">
                        <i class="icon-bag"></i>
                        <span>จัดการสินค้า</span>
                    </a>
                </li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["order", "order.detail"]))? "active": ""; ?>">
                    <a href="order.php">
                        <i class="icon-social-dropbox"></i>
                        <span>จัดการออเดอร์</span>
                    </a>
                </li>
                <li class="nav-header">สมาชิก</li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["user", "user.view", "user_add"," user.edit"]))? "active": ""; ?>">
                    <a href="user.php">
                        <i class="fas fa-user"></i>
                        <span>จัดการสมาชิก</span>
                    </a>
                </li>
                <li class="nav-header">เเอดมิน</li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["admin", "admin.view", "admin_add"," admin.edit"]))? "active": ""; ?>">
                    <a href="admin.php">
                        <i class="fas fa-user-alt"></i>
                        <span>จัดการแอดมิน</span>
                    </a>
                </li>
                <li
                    class="<?php echo (in_array(explode(".php", basename($_SERVER['REQUEST_URI']))[0], ["bank", "user.view"]))? "active": ""; ?>">
                    <a href="bank.php">
                        <i class="fa fa-bank"></i>
                        <span>จัดการบัญชีธนาคาร</span>
                    </a>
                </li>
                <!-- begin sidebar minify button -->
                <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                            class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar minify button -->
            </ul>
            <!-- end sidebar nav -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->