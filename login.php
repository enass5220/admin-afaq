<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>تسجيل الدخول</title>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0" style="direction:rtl;">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="../../assets/images/logo.svg" alt="logo">
                            </div>
                            <h4 class="card-title"> تسجيل الدخول</h4>
                            <h6 class="font-weight-light"> قم بتسجيل الدخول إلى حسابك لمتابعة شحناتك </h6>
                            <form class="pt-3">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">الدخول</a>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <!-- <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> تذكرني؟ </label>
                                    </div> -->
                                    <a href="#" class="auth-link text-black">هل نسيت كلمة المرور؟</a>
                                </div>
                                <div class="text-center mt-4 font-weight-light"> ليس لديك حساب؟ <a href="register.html" class="text-primary">قم بإنشاء حسابك</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php'; ?>
</body>

</html>