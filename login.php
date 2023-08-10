<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://media.discordapp.net/attachments/1128198864629940244/1128967842545545287/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <style>
        .form-link {
            display: flex;
            justify-content: space-between;
            /* จัดลิงก์ให้อยู่ห่างกันทั้งสองข้าง */
        }

        .link {
            color: blue;
            /* สีของลิงก์ "สมัครสมาชิก" */
            text-decoration: underline;
            /* เส้นใต้ข้อความลิงก์ "สมัครสมาชิก" */
        }

        .forgot-pass {
            color: red;
            /* สีของลิงก์ "ลืมรหัสผ่าน" */
            text-decoration: underline;
            /* เส้นใต้ข้อความลิงก์ "ลืมรหัสผ่าน" */
        }

        .container {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #b2b2be;
            column-gap: 30px;
        }
    </style>
    <!-- login -->
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>เข้าสู่ระบบ</header>
                <form action="process_login.php" method="POST" class="margin-bottom-0" data-parsley-validate="true">
                    <div class="field input-field">
                        <input type="text" class="form-control form-control-lg" name="user_username" placeholder="ชื่อผู้ใช้" data-parsley-required="true" value="" />
                    </div>
                    <div class="field input-field">
                        <input type="password" class="form-control form-control-lg password" name="user_password" placeholder="รหัสผ่าน" data-parsley-required="true" value="" />
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field button-field">
                        <button>เข้าสู่ระบบ</button>
                    </div>
                </form>
                <div class="form-link">
                    <span><a href="#" class="link signup-link">สมัครสมาชิก</a></span>

                </div>
            </div>
            <div class="line"></div>
            <div class="media-options">
                <a href="#" class="field google">
                    <img src="https://media.discordapp.net/attachments/1120961499196821596/1133309194368467104/-removebg-preview.png" alt="" class="google-img">
                    <span>Login with Google</span>
                </a>
            </div>
        </div>
        <!-- Register Form -->
        <div class="form signup">
            <div class="form-content">
                <header>สมัครสมาชิก</header>
                <form action="process_register.php" method="POST" class="margin-bottom-0" data-parsley-validate="true">
                    <div class="field input-field">
                        <input type="text" class="form-control form-control-lg" name="user_fullname" placeholder="ชื่อ-สกุล" data-parsley-required="true" />
                    </div>
                    <div class="field input-field">
                        <input type="email" class="form-control form-control-lg" name="user_email" placeholder="อีเมล" data-parsley-required="true" data-parsley-type="email" />
                    </div>

                    <div class="field input-field">
                        <input type="text" class="form-control form-control-lg" name="user_username" placeholder="ชื่อผู้ใช้" data-parsley-required="true" />
                    </div>
                    <div class="field input-field">
                        <input type="password" class="form-control form-control-lg password" name="user_password" placeholder="รหัสผ่าน" data-parsley-required="true" value="" />
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field button-field">
                        <button>สมัครสมาชิก</button>
                    </div>
                </form>
                <div class="form-link">
                    <span><a href="#" class="link login-link">เข้าสู่ระบบ</a></span>
                </div>
            </div>
            <div class="line"></div>
            <div class="media-options">
                <a href="#" class="field google">
                    <img src="https://media.discordapp.net/attachments/1120961499196821596/1133309194368467104/-removebg-preview.png" alt="" class="google-img">
                    <span>Login with Google</span>
                </a>
            </div>
        </div>
    </section>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>