<?php 
	if(!isset($_SESSION)){
		session_start();
	}
	include('config.php'); 
	$sql = "SELECT *,(SELECT count(brand_id) FROM product WHERE brand_id = brands.brand_id)as count FROM brands";
	$resultBrands = $conn->query($sql);

	$sql = "SELECT *,(SELECT count(category_id) FROM product WHERE category_id = categories.category_id)as count FROM categories";
	$resultCategories = $conn->query($sql);

	$sql = "SELECT *,(SELECT count(seller_id) FROM product WHERE seller_id = seller.seller_id)as count FROM seller WHERE seller_status = 1";
	$resultSeller = $conn->query($sql);

	if(isset($_SESSION['user_id'])){
		$sql = "SELECT * FROM notifications WHERE user_id = ".$_SESSION['user_id']. " AND DATE(show_notification) > (NOW() - INTERVAL 7 DAY) AND DATE(show_notification) < (NOW()) ORDER BY noti_id DESC LIMIT 8";
		$resultNotifications = $conn->query($sql);
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="https://media.discordapp.net/attachments/1120961499196821596/1132934419204816986/logo.png">
    <title>บริษัทขายเครื่องกรองน้ำ A&P</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- Bootstrap CSS -->
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link href="dist/css/default/app.min.css" rel="stylesheet" />
    <link href="dist/css/e-commerce/app.min.css" rel="stylesheet" />
    <!-- Smart Wizard CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/smartwizard/4.3.1/css/smart_wizard.css" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- DataTables CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.20/dataTables.bootstrap4.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.1/responsive.bootstrap4.min.css"
        rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->
</head>
<style>
::-webkit-scrollbar {
    width: 8px;
}

.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}

.b-example-divider {
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
}

.b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555;
}

@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

output {
    min-height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.bg-white {
    background-color: #fff;
}

.shadow-sm {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

body {
    background-color: #eeeeee;
    font-family: 'Open Sans', serif;
    font-size: 14px
}

.container-fluid {
    margin-top: 50px
}

S .footer-copyright {
    margin-top: 13px
}

a {
    text-decoration: none !important;
    color: #777a7c
}

.description {
    font-size: 12px
}

.fa-facebook-f {
    color: #3b5999
}

.fa-instagram {
    color: #e4405f
}

.fa-youtube {
    color: #cd201f
}

.fa-twitter {
    color: #55acee
}

.logo-footer {
    height: 30px;
}

.footer-copyright p {
    margin-top: 10px
}

.container-fluid {
    width: 100%;
    max-width: 100%;
    margin-left: auto;
}

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

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background: #348fe2 !important;
    color: #f2f3f4 !important;
}

.select2.select2-container .selection .select2-selection.select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
    color: rgba(0, 0, 0, .6) !important;
}

body {
    font-size: 16px;
    color: black;
}

h1 {
    font-size: 24px;
    color: black;
}

p {
    font-size: 14px;
    color: black;
}

.carousel-item.active {
    background-position: center center;
}

.product-img {
    width: 85%;
    height: auto;

}

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
</head>



<!-- BEGIN #top-nav -->
<div id="top-nav" class="top-nav">
    <!-- BEGIN container -->
    <div class="container">
        <div class="collapse navbar-collapse">
            <?php if(isset($_SESSION['user_id'])){ ?>
            <!-- User is logged in -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">ออกจากระบบ</a></li>
                <li><a href="order.php">ประวัติการสั่งซื้อ</a></li>
                <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
            </ul>
        </div>

        <?php } ?>
    </div>
</div>
<!-- end header-nav -->
</div>
<!-- END container -->
</div>

<!-- end header-nav -->
</div>
<!-- END container -->
</div>
<!-- END #top-nav -->

<!-- BEGIN #header -->
<div id="header" class="header" data-fixed-top="true">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN header-container -->
        <div class="header-container">
            <!-- BEGIN navbar-toggle -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- END navbar-toggle -->
            <!-- BEGIN header-logo -->
            <div class="header-logo">
                <a href="./">
                    <!-- <span class="brand-logo"></span> -->
                    <img src="https://media.discordapp.net/attachments/1120961499196821596/1132934419204816986/logo.png"
                        class="ml-2 mr-3" style="width: 50px; height: 50px;">
                    <span class="brand-text">
                        <span class="text-primary">C</span>hamp <span class="text-primary"><span
                                class="text-primary">S</span>hop
                            <small>ร้านค้า ขายเครื่องกรองนํ้า A & P</small>
                        </span>
                </a>
            </div>
            <!-- END header-logo -->
            <!-- BEGIN header-nav -->
            <div class="header-nav">
                <div class=" collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav">
                        <li><a href="./">หน้าหลัก</a></li>
                        <li class="dropdown dropdown-full-width dropdown-hover">
                            <a href="#" data-toggle="dropdown">
                                ร้านค้าของเรา
                                <b class="caret"></b>
                                <span class="arrow top"></span>
                            </a>
                            <!-- BEGIN dropdown-menu -->
                            <div class="dropdown-menu p-0">
                                <!-- BEGIN dropdown-menu-container -->
                                <div class="dropdown-menu-container">
                                    <!-- BEGIN dropdown-menu-sidebar -->
                                    <div class="dropdown-menu-sidebar">
                                        <h4 class="title">หมวดหมู่</h4>
                                        <ul class="dropdown-menu-list">
                                            <?php foreach ($resultCategories as $item){ ?>
                                            <li><a
                                                    href="<?php echo ($item['count'] == 0)?"#" :"product.php?category=".$item['category_id']; ?>"><?php echo $item['category_name']; ?>
                                                    <span class="pull-right">(<?php echo $item['count']; ?>)</span></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <!-- END dropdown-menu-sidebar -->
                                    <!-- BEGIN dropdown-menu-content -->
                                    <div class="dropdown-menu-content">
                                        <h4 class="title">ร้านค้า</h4>
                                        <div class="row">
                                            <?php foreach ($resultSeller as $item){ ?>
                                            <div class="col-lg-3">
                                                <ul class="dropdown-menu-list">
                                                    <li><a
                                                            href="<?php echo ($item['count'] == 0)?"#" :"product.php?shop=".$item['seller_id']; ?>"><i
                                                                class="fa fa-fw fa-angle-right text-muted"></i>
                                                            <?php echo $item['seller_shop']; ?> <span
                                                                class="pull-right">(<?php echo $item['count']; ?>)</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <h4 class="title">แบรนด์</h4>
                                        <ul class="dropdown-brand-list m-b-0">
                                            <?php foreach ($resultBrands as $item){ ?>
                                            <li><a
                                                    href="<?php echo ($item['count'] == 0)?"#" :"product.php?brand=".$item['brand_id']; ?>"><img
                                                        src="<?php echo $item['brand_image']; ?>"
                                                        onError="this.src='https://media.discordapp.net/attachments/1128198864629940244/1128967842545545287/logo.png'" /></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <!-- END dropdown-menu-content -->
                                </div>
                                <!-- END dropdown-menu-container -->
                            </div>
                            <!-- END dropdown-menu -->
                        </li>
                        <li><a href="product.php">สินค้าทั้งหมด</a></li>
                        <li class="dropdown dropdown-hover">
                            <a href="#" data-toggle="dropdown">
                                <i class="fa fa-search search-btn"></i>
                                <span class="arrow top"></span>
                            </a>
                            <div class="dropdown-menu p-15">
                                <form action="product.php" method="GET" name="search_form">
                                    <div class="input-group">
                                        <input type="text" placeholder="ค้นหาสินค้า" name="q"
                                            class="form-control bg-silver-lighter"
                                            value="<?php echo (isset($_GET['q']) && $_GET['q'] !== '')? $_GET['q']: ""; ?>" />
                                        <div class="input-group-append">
                                            <button class="btn btn-inverse" type="submit"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END header-nav -->
            <!-- BEGIN header-nav -->
            <div class="header-nav">
                <ul class="nav pull-right">
                    <?php if(isset($_SESSION['user_id'])){ ?>
                    <li class="dropdown dropdown-hover dropdown-notification">
                        <a href="#" class="header-cart" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="total"><?php echo $resultNotifications->num_rows; ?></span>
                            <span class="arrow top"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-cart p-0">
                            <div class="cart-header">
                                <h4 class="cart-title">การแจ้งเตือน (<?php echo $resultNotifications->num_rows; ?>)
                                </h4>
                            </div>
                            <div class="cart-body">
                                <ul class="cart-item">
                                    <?php 
												if($resultNotifications->num_rows > 0){
													foreach ($resultNotifications as $list){ 
											?>
                                    <li class="d-flex align-items-center">
                                        <div class="cart-item-image p-0"
                                            style="width: 3rem; height: 2.75rem; border: 0px;"><img src="img/user.png"
                                                class="user-img" alt="" />


                                        </div>
                                        <div class="cart-item-info">
                                            <a href="product_detail.php?id=<?php echo $list['product_id']; ?>"
                                                style="text-decoration: none; color: inherit;">
                                                <h4><?php echo $list['product_name']; ?> ของคุณใกล้หมดรึยังน๊าาา
                                                </h4>
                                                <p class="price">แสดงถึง: <?php echo $list['show_notification']; ?>
                                                </p>
                                            </a>
                                        </div>
                                    </li>
                                    <?php } }else { ?>
                                    <li>
                                        <div class="cart-item-info p-0">
                                            <h4 class="text-center">ไม่มีการแจ้งเตือน</h4>
                                        </div>
                                        <!-- <div class="cart-item-close">
													<a data-toggle="tooltip">&times;</a>
												</div> -->
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <!-- <div class="cart-footer">
										<div class="row row-space-10">
											<div class="col-12">
												<a href="#" class="btn btn-default btn-theme btn-block">ดูการแจ้งเตือนทั้งหมด</a>
											</div>
										</div>
									</div> -->
                        </div>
                    </li>
                    <li class="dropdown dropdown-hover dropdown-cart">
                        <a href="#" class="header-cart" data-toggle="dropdown">
                            <i class="fa fa-shopping-bag"></i>
                            <span class="total">2</span>
                            <span class="arrow top"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-cart p-0">
                            <div class="cart-header">
                                <h4 class="cart-title">ตะกร้าสินค้า (x) </h4>
                            </div>
                            <div class="cart-body">
                                <ul class="cart-item">

                                </ul>
                            </div>
                            <div class="cart-footer">
                                <div class="row row-space-10">
                                    <div class="col-12">
                                        <a href="checkout_cart.php"
                                            class="btn btn-default btn-theme btn-block">ดูสินค้าในตะกร้าทั้งหมด</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <?php if (isset($_SESSION['admin_id']) && !isset($_SESSION['seller_fullname'])) { // Check if it is an admin ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://media.discordapp.net/attachments/1128198864629940244/1128955900594495488/istockphoto-1300845620-612x612.png?width=473&height=473"
                                class="user-img" alt="" />


                            <span class="d-none d-xl-inline">
                                <?php echo isset($_SESSION['admin_fullname']) ? $_SESSION['admin_fullname'] : "เข้าสู่ระบบ"; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="admin/index.php">ดูหลังบ้าน</a>
                            <a class="dropdown-item" href="admin/logout.php">ออกจากระบบ</a>
                        </div>
                    </li>
                    <?php } elseif (isset($_SESSION['seller_fullname'])) { // Check if it is a seller ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://media.discordapp.net/attachments/1128198864629940244/1128955900594495488/istockphoto-1300845620-612x612.png?width=473&height=473"
                                class="user-img" alt="" />
                            <span class="d-none d-xl-inline">
                                <?php echo isset($_SESSION['seller_fullname']) ? $_SESSION['seller_fullname'] : "เข้าสู่ระบบ"; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="admin/index.php">ดูหลังบ้าน</a>
                            <a class="dropdown-item" href="admin/logout.php">ออกจากระบบ</a>
                        </div>
                    </li>
                    <?php } else { ?>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo (isset($_SESSION['user_id'])) ? "profile.php" : "login.php" ?>">
                            <img src="https://media.discordapp.net/attachments/1128198864629940244/1128955900594495488/istockphoto-1300845620-612x612.png?width=473&height=473"
                                class="user-img" alt="" />
                            <span class="d-none d-xl-inline">
                                <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_fullname'] : "เข้าสู่ระบบ"; ?>
                            </span>
                        </a>
                    </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Smart Wizard JavaScript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/smartwizard/4.3.1/js/jquery.smartWizard.min.js"></script> -->
<!-- Select2 JavaScript -->
<!-- <script src="dist/plugins/select2/dist/js/select2.min.js"></script> -->
<!-- DataTables JavaScript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/1.10.20/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.10.20/dataTables.bootstrap4.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.3/dataTables.responsive.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js"> -->
<!-- </script> -->
<script src="dist/js/e-commerce/app.min.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script type="text/javascript" src="https://cdn.omise.co/omise.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smartwizard/4.3.1/js/jquery.smartWizard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/3.2.2/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.3/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.5.0/responsive.bootstrap4.min.js">
</script>
<script src="dist/js/demo/table-manage-default.demo.js"></script>