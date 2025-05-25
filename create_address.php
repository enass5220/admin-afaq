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
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">إضافة عنوان شحن جديد</h4>
                                <p class="card-description">أدخل تفاصيل عنوان الشحن.</p>
                                
                                <form class="forms-sample" action="process_create_address.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">الدولة</label>
                                                <input type="text" class="form-control" id="country" name="country" placeholder="مثال: ليبيا" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shipping_type">نوع الشحن للعنوان</label>
                                                <select class="form-select" id="shipping_type" name="shipping_type" required>
                                                    <option value="">اختر نوع الشحن</option>
                                                    <option value="جوي">جوي</option>
                                                    <option value="بحري">بحري</option>
                                                    <option value="بري">بري</option>
                                                    <option value="متعدد">متعدد الوسائط</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="location_address">عنوان الموقع التفصيلي</label>
                                        <textarea class="form-control" id="location_address" name="location_address" rows="4" placeholder="مثال: شارع الجمهورية, طرابلس, مستودع رقم 5" required></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="is_active">الحالة</label>
                                        <select class="form-control" id="is_active" name="is_active" required>
                                            <option value="1">فعال</option>
                                            <option value="0">غير فعال</option>
                                        </select>
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