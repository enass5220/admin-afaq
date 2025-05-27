<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php'; // Assuming head.php contains meta tags, CSS links etc. 
    ?>
    <title>تعديل سعر شحن </title>
</head>

<body dir="rtl">
    <div class="container-scroller">
        <?php include 'navbar.php'; // Assuming navbar.php contains the top navigation bar 
        ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'; // Assuming sidebar.php contains the side navigation 
            ?>
            <div class="main-panel">
                <div class="content-wrapper" style="direction: rtl;">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">تعديل سعر شحن </h4>
                                    <p class="card-description">أدخل تفاصيل سعر الشحن الجديدة.</p>

                                    <form class="forms-sample" action="process_create_shipping.php" method="POST">
                                        <div class="form-group">
                                            <label for="address">عنوان الشحن</label>
                                            <select dir=""class="form-select" id="address" name="address" required>
                                                <option selected disabled>اختر</option>
                                                <option value="1">تركيا جوي</option>
                                                <option value="2">تركيا بحري</option>
                                                <option value="3">الإمارات جوي</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="measurement_unit">وحدة القياس</label>
                                                    <input type="text" class="form-control" id="measurement_unit" name="measurement_unit" placeholder="مثال: 1 kg أو 1 cbm" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="price">السعر لكل وحدة</label>
                                                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="مثال: 3.50" required>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="currency">العملة</label>
                                                    <select class="form-select" id="currency" name="currency" required>
                                                        <option value="USD">USD</option>
                                                        <option value="EUR">EUR</option>
                                                        <option value="TRY">TRY</option>
                                                        <option value="SAR">SAR</option>
                                                        <!-- Add other currencies as needed -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-check col-md-6 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status" id="statusActive" value="مٌفعل" checked>
                                                    <label class="form-check-label" for="statusActive">
                                                        مٌفعل
                                                    </label>
                                                </div>
                                                <div class="form-check col-md-6 form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status" id="statusInactive" value="غير مٌفعل">
                                                    <label class="form-check-label" for="statusInactive">
                                                        غير مٌفعل
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-2">تعديل السعر</button>
                                        <a href="shipprices.php" class="btn btn-light">إلغاء</a> <!-- Assuming your list page is shipping_prices.php -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'footer.php'; // Assuming footer.php contains footer content 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php'; // Assuming js.php contains JavaScript files 
    ?>
</body>

</html>