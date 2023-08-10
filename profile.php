		<?php
		include('config.php');
		include('includes/authentication.php');
		include('includes/header.php');

		$sql = "SELECT * FROM categories";
		$result = $conn->query($sql);
		?>
		<style>
.form-control {
    border: 1px solid #ced4da !important;
}
		</style>
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
		            <div class="account-body" style="height: 100%;min-height: 650px;background-color: #d9e0e7;">
		                <!-- BEGIN row -->
		                <div class="row">
		                    <!-- BEGIN col-6 -->
		                    <div class="col-md-12">
		                        <!-- begin panel -->
		                        <form action="process_profile.php" method="POST" data-parsley-validate="true">
		                            <div class="panel panel-default">
		                                <div class="panel-heading">
		                                    <h4 class="panel-title" style="font-size: 20px"><i
		                                            class="fa fa-universal-access fa-fw text-primary"></i> จัดการบัญชีของฉัน
		                                    </h4>
		                                </div>
		                                <div class="panel-body">
		                                    <div class="row">
		                                        <div class="col-4">
		                                            <div class="form-group">
		                                                <label>ชื่อผู้ใช้ (ไม่สามารถเปลี่ยนได้)</label>
		                                                <input type="text" class="form-control" placeholder="ชื่อผู้ใช้"
		                                                    disabled value="<?php echo $_SESSION['user_username'] ?>">
		                                            </div>
		                                        </div>
		                                        <div class="col-4">
		                                            <div class="form-group">
		                                                <label for="user_fullname">ชื่อ-สกุล</label>
		                                                <input type="text" class="form-control" id="user_fullname"
		                                                    name="user_fullname" placeholder="ชื่อ-สกุล"
		                                                    data-parsley-required="true"
		                                                    value="<?php echo $_SESSION['user_fullname'] ?>">
		                                            </div>
		                                        </div>
		                                        <div class="col-4">
		                                            <div class="form-group">
		                                                <label>อีเมล (ไม่สามารถเปลี่ยนได้)</label>
		                                                <input type="text" class="form-control" placeholder="อีเมล" disabled
		                                                    value="<?php echo $_SESSION['user_username'] ?>">
		                                            </div>
		                                        </div>
		                                        <div class="col-4">
		                                            <div class="form-group">
		                                                <label for="user_tel">เบอร์ติดต่อ</label>
		                                                <input type="text" class="form-control" id="user_tel" name="user_tel"
		                                                    placeholder="เบอร์ติดต่อ" data-parsley-required="true"
		                                                    value="<?php echo $_SESSION['user_tel'] ?>">
		                                            </div>
		                                        </div>
		                                        <div class="col-4">
		                                            <div class="form-group">
		                                                <label for="user_address">ที่อยู่</label>
		                                                <textarea class="form-control" id="user_address" name="user_address"
		                                                    placeholder="ที่อยู่"
		                                                    data-parsley-required="true"><?php echo $_SESSION['user_address'] ?></textarea>
		                                            </div>
		                                        </div>
		                                        <div class="col-4">
		                                            <div class="form-group">
		                                                <label for="user_pet">ประเภทสัตว์เลี้ยง</label>
		                                                <select class="multiple-select2 form-control" id="user_pet"
		                                                    name="user_pet[]" multiple data-parsley-group="step-3"
		                                                    data-parsley-required="true">
		                                                    <?php foreach ($result as $list) { ?>
		                                                    <option value="<?php echo $list['category_name']; ?>"
		                                                        <?php echo (str_contains($_SESSION['user_pet'], $list['category_name'])) ? "selected" : ""; ?>>
		                                                        <?php echo $list['category_name']; ?></option>
		                                                    <?php } ?>
		                                                </select>
		                                            </div>
		                                        </div>
		                                        <div class="col-6">
		                                            <div class="form-group">
		                                                <label for="user_password">รหัสผ่าน (หากไม่เปลี่ยน
		                                                    โปรดปล่อยว่าง)</label>
		                                                <input type="password" id="user_password" name="user_password"
		                                                    placeholder="รหัสผ่าน" class="form-control"
		                                                    data-parsley-equalto="#user_password_confirm" />
		                                            </div>
		                                        </div>
		                                        <div class="col-6">
		                                            <div class="form-group">
		                                                <label for="user_password_confirm">ยืนยันรหัสผ่าน (หากไม่เปลี่ยน
		                                                    โปรดปล่อยว่าง)</label>
		                                                <input type="password" id="user_password_confirm"
		                                                    name="user_password_confirm" placeholder="ยืนยันรหัสผ่าน"
		                                                    class="form-control" data-parsley-equalto="#user_password" />
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="panel-footer text-right">
		                                    <button type="submit" class="btn btn-success m-l-5">แก้ไขข้อมูลส่วนตัว</button>
		                                </div>
		                            </div>
		                        </form>
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