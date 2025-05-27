<!DOCTYPE html>
<html lang="ar">
<head>
    <?php include 'head.php'; // Assuming head.php contains meta tags, CSS links etc. ?>
    <title>إضافة سعر صرف جديد</title>
</head>
<body dir="rtl">
<div class="container-scroller">
    <?php include 'navbar.php'; // Assuming navbar.php contains the top navigation bar ?>
    <div class="container-fluid page-body-wrapper">
        <?php include 'sidebar.php'; // Assuming sidebar.php contains the side navigation ?>
        <div class="main-panel" style="direction: rtl;">
            <div class="content-wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">إضافة سعر صرف جديد</h4>
                                <p class="card-description">أدخل تفاصيل سعر الصرف الجديد مقابل الدينار الليبي.</p>
                                
                                <form class="forms-sample" action="process_create_exchange_rate.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="currency_name">اسم العملة</label>
                                                <input type="text" class="form-control" id="currency_name" name="currency_name" placeholder="مثال: الدولار الأمريكي" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="currency_code">رمز العملة</label>
                                                <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="مثال: USD" required>
                                            </div>
                                        </div>

                                    <div class=" col-md-4 form-group">
                                        <label for="value_vs_dinar">القيمة مقابل الدينار</label>
                                        <input type="number" step="0.001" class="form-control" id="value_vs_dinar" name="value_vs_dinar" placeholder="مثال: 5.600" required>
                                        <small class="form-text text-muted">أدخل قيمة العملة الأجنبية الواحدة بالدينار الليبي.</small>
                                    </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="status">الحالة</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked name="isactive" id="checkNativeSwitch" switch>
                                            <label class="form-check-label" for="checkNativeSwitch">
                                                مُفعل
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary mr-2">إضافة السعر</button>
                                    <a href="exchange_rates_list.php" class="btn btn-light">إلغاء</a> <!-- Adjust if your list page is named differently -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'footer.php'; // Assuming footer.php contains footer content ?>
            </div>
        </div>
    </div>
</div>
<?php include 'js.php'; // Assuming js.php contains JavaScript files ?>
</body>
</html>