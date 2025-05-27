<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php'; ?>
    <title>إضافة عنوان شحن جديد</title>
</head>

<body dir="rtl">
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper" style="direction: rtl;">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">إضافة عنوان شحن جديد</h4>
                                    <p class="card-description">أدخل تفاصيل عنوان الشحن.</p>

                                    <form class="forms-sample" action="process_create_address.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="country">الدولة</label>
                                                    <input type="text" class="form-control" id="country" name="country" placeholder="مثال: ليبيا" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="shipping_type">نوع الشحن </label>
                                                    <select class="form-select" dir="" id="shipping_type" name="shipping_type" required>
                                                        <option selected disabled>اختر نوع الشحن</option>
                                                        <option value="1">جوي</option>
                                                        <option value="2">بحري</option>
                                                        <option value="3">بري</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked name="isactive" id="checkNativeSwitch" switch>
                                                    <label class="form-check-label" for="checkNativeSwitch">
                                                        مُفعل
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="location_address">عنوان الموقع التفصيلي</label>
                                            <textarea class="form-control" id="location_address" name="location_address" rows="4" placeholder="مثال: شارع الجمهورية, طرابلس, مستودع رقم 5" required></textarea>
                                        </div>


                                        <button type="submit" class="btn btn-primary mr-2">إضافة العنوان</button>
                                        <a href="shipaddresses.php" class="btn btn-light">إلغاء</a>
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