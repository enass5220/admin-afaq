<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الزبائن | زبون جديد</title>
</head>

<body >
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
                <?php include 'sidebar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-6 mx-auto grid-margin stretch-card" style="direction: rtl;">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> زبون جديد</h4>
                                    <p class="card-description"> انشاء حساب لزبون جديد </p>
                                    <form class="forms-sample">
                                        <div class="form-group">
                                            <label for="username">اسم المستخدم</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="اسم المستخدم">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">البريد الالكتروني</label>
                                            <input type="email" class="form-control" id="email" placeholder="البريد الالكتروني" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">رقم الهاتف </label>
                                            <input type="phone" class="form-control" id="phone" placeholder="رقم الهاتف " name="phone">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">كلمة المرور</label>
                                            <input type="password" class="form-control" placeholder="كلمة المرور" name="password1" id="password1">
                                        </div>
                                        <div class="form-group">
                                            <label for="password2">تأكيد كلمة المرور</label>
                                            <input type="password" class="form-control" id="password2" placeholder="اعد كتابة كلمة المرور">
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">تسجيل</button>
                                        <button class="btn btn-light">إلغاء</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php'; ?>
</body>

</html>