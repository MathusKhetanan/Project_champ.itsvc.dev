<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Responsive Login and Signup Form </title>

        <!-- CSS -->
        <link rel="stylesheet" href="../css/style.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
                        
    </head>
    <body>
        <!-- login -->
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Login</header>
                    <form action="process_login.php" method="POST" class="margin-bottom-0" data-parsley-validate="true">
                        <div class="field input-field">
						<input type="text" class="form-control form-control-lg" name="seller_username" placeholder="ชื่อผู้ใช้" data-parsley-required="true" value="Shop01" />
                        </div>

                        <div class="field input-field">
						<input type="password" class="form-control form-control-lg" name="seller_password" placeholder="รหัสผ่าน" data-parsley-required="true" value="123456" />
                            <i class='bx bx-hide eye-icon'></i>
                        </div>

                        <div class="form-link">
                            <a href="#" class="forgot-pass">Forgot password?</a>
                        </div>

                        <div class="field button-field">
                            <button>Login</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Don't have an account? <a href="#" class="link signup-link">Signup</a></span>
                    </div>
                </div>

                <div class="line"></div>

                <div class="media-options">
                    <a href="#" class="field facebook">
                        <i class='bx bxl-facebook facebook-icon'></i>
                        <span>Login with Facebook</span>
                    </a>
                </div>

                <div class="media-options">
                    <a href="#" class="field google">
                        <img src="images/google.png" alt="" class="google-img">
                        <span>Login with Google</span>
                    </a>
                </div>

            </div>

            <!-- Register Form -->

            <div class="form signup">
                <div class="form-content">
                    <header>Register</header>
                    <form action="process_register.php" method="POST" class="margin-bottom-0" data-parsley-validate="true">
                        <div class="field input-field">
                        <input type="text" class="form-control form-control-lg" name="seller_fullname" placeholder="ชื่อ-สกุล" data-parsley-required="true" />
                        </div>

                        <div class="field input-field">
                        <input type="email" class="form-control form-control-lg" name="seller_email" placeholder="อีเมล" data-parsley-required="true" data-parsley-type="email" />
                        </div>

                        <div class="field input-field">
                        <input type="text" class="form-control form-control-lg" name="seller_username" placeholder="ชื่อผู้ใช้" data-parsley-required="true" />
                            <i class='bx bx-hide eye-icon'></i>
                        </div>

                        <div class="field input-field">
                        <input type="password" class="form-control form-control-lg" name="seller_password" placeholder="รหัสผ่าน" data-parsley-required="true" />
                        </div>

                        <div class="field button-field">
                            <button>Signup</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
                    </div>
                </div>

                <div class="line"></div>

                <div class="media-options">
                    <a href="#" class="field facebook">
                        <i class='bx bxl-facebook facebook-icon'></i>
                        <span>Login with Facebook</span>
                    </a>
                </div>

                <div class="media-options">
                    <a href="#" class="field google">
                        <img src="images/google.png" alt="" class="google-img">
                        <span>Login with Google</span>
                    </a>
                </div>

            </div>
        </section>

        <!-- JavaScript -->
        <script src="../js/script.js"></script>
    </body>
</html>