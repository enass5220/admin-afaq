<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الشحنات | شحنة جديدة</title>
</head>

<body dir="rtl">
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-10 mx-auto grid-margin stretch-card" style="direction: rtl;">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">شحنة جديدة</h4>
                                    <p class="card-description"> انشاء طلبية لزبون </p>
                                    <form class="forms-sample p-3 border rounded shadow-sm"> <!-- Added padding, border, and shadow for visual structure -->

                                        <h5 class="mb-4 border-bottom pb-2">معلومات الزبون والطلب</h5> <!-- Section Title -->

                                        <div class="row">
                                            <div class="col-md-6 mb-3"> <!-- Use columns for better layout on medium screens -->
                                                <label for="username" class="form-label">اسم المستخدم</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="username" aria-label="Username" aria-describedby="lookupUserBtn" name="username" placeholder="اسم المستخدم">
                                                    <button type="button" name="lookupUser" id="lookupUserBtn" class="btn btn-outline-secondary"><i class="fa fa-search"></i></button> <!-- Changed to outline button -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="orderno" class="form-label">رقم الطلب (Order Number)</label>
                                                <input type="text" dir="" required class="form-control" id="orderno" aria-label="Order Number" name="orderno" placeholder="رقم الطلب في shein">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="trackno" class="form-label">رقم الشحن (Tracking Number)</label>
                                                <input type="text" dir="" class="form-control" id="trackno" aria-label="Tracking Number" name="trackno" placeholder="رقم الشحن في shein (اختياري)">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="olink" class="form-label">رابط الطلبية / السلة</label>
                                                <input type="url" dir="" required class="form-control" id="olink" aria-label="Order link" name="olink" placeholder="https://...">
                                            </div>
                                        </div>

                                        <hr class="my-4"> <!-- Separator -->
                                        <h5 class="mb-4 border-bottom pb-2">تفاصيل السعر والشحن</h5> <!-- Section Title -->

                                        <!-- Price Information Section -->
                                        <div class="row mb-3 align-items-end"> <!-- align-items-end helps align labels/inputs vertically if heights differ slightly -->
                                            <div class="col-md-6 mb-3">
                                                <label for="total_price_orig" class="form-label">السعر الإجمالي (العملة الأصلية)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" required class="form-control" id="total_price_orig" name="total_price_orig" placeholder="150.50" aria-label="اجمالي السعر بالدولار">
                                                    <span class="input-group-text">$ دولار</span> <!-- Example currency, adjust as needed -->
                                                </div>
                                            </div>
                                            <div class="col-6 my-auto">

                                                <label for="exchange_rate" class="form-label">سعر الصرف</label>
                                                <select class="form-select" dir="" id="exchange_rate" name="exchange_rate" required aria-label="Exchange Rate">
                                                    <option value="" selected disabled>-- اختر سعر الصرف --</option>
                                                    <option value="5.50">5.50 LYD/USD</option>
                                                    <option value="5.45">5.45 LYD/USD</option>
                                                    <option value="6.80">6.80 LYD/EUR</option>
                                                    <!-- Add more predefined rates here -->
                                                    <!-- Or these could be populated dynamically -->
                                                </select>
                                                <!-- If you prefer a modal:
                                                <input type="hidden" id="selected_exchange_rate_value" name="exchange_rate">
                                                <div class="input-group">
                                                    <input type="text" id="display_exchange_rate" class="form-control" placeholder="لم يتم الاختيار" readonly>
                                                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#exchangeRateModal">اختر</button>
                                                </div>
                                                Add the modal HTML structure elsewhere in your page
                                                -->
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-end">
                                            <div class="col-md-6 mb-3">
                                                <label for="total_price_lyd" class="form-label">السعر النهائي (دينار ليبي)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" class="form-control" id="total_price_lyd" name="total_price_lyd" placeholder="يتم حسابه تلقائياً" aria-label="Final Total Price LYD" readonly> <!-- Make readonly if calculated -->
                                                    <span class="input-group-text">LYD</span>
                                                </div>
                                                <small class="form-text text-muted">سيتم تحديثه بناءً على السعر الأصلي وسعر الصرف.</small>
                                            </div>
                                            <div class="col-md-6 my-auto">
                                                <label for="shipment_method" class="form-label">طريقة الشحن</label>
                                                <select dir="" class="form-select" id="shipment_method" name="shipment_method" dir="" required>
                                                    <option value="" selected disabled>-- اختر طريقة الشحن --</option>
                                                    <option value="air">شحن جوي</option>
                                                    <option value="sea">شحن بحري</option>
                                                    <option value="express">شحن سريع</option>
                                                    <!-- Add other shipment methods as needed -->
                                                </select>
                                                <small class="form-text text-muted">سيتم حساب تكلفة الشحن بناءً على الوزن عند الاستلام.</small>
                                            </div>
                                        </div>
                                        <!-- End Price Information Section -->

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="ostate" class="form-label">حالة الشحنة (للمشرف)</label> <!-- Clarified label -->
                                                <select dir="" class="form-select" id="ostate" name="ostate">
                                                    <option value="1" selected>تم الانشاء</option>
                                                    <option value="2">وصلت إلى المخزن الخارجي</option>
                                                    <option value="3">وصلت إلى مخزن ليبيا</option>
                                                    <option value="4">جاهز للتسليم</option>
                                                    <option value="5">تم التسليم</option>
                                                    <!-- Add more states if needed -->
                                                </select>
                                                <!-- This field might typically be disabled for the user and only editable by admin -->
                                            </div>
                                        </div>


                                        <!-- Regarding Confirmation Page: Backend feature needed -->
                                        <!-- ... (comment remains the same) ... -->

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-end"> <!-- Align buttons to the right -->
                                            <button type="button" class="btn btn-light me-3">إلغاء</button> <!-- Added margin -->
                                            <button type="submit" class="btn btn-primary">انشاء الطلب</button> <!-- Changed text slightly -->
                                        </div>

                                    </form>

                                    <!-- Optional: Add this basic Javascript for automatic calculation -->
                                    <script>
                                        const priceOrigInput = document.getElementById('total_price_orig');
                                        const exchangeRateSelect = document.getElementById('exchange_rate');
                                        const priceLydInput = document.getElementById('total_price_lyd');

                                        function calculateFinalPrice() {
                                            const priceOrig = parseFloat(priceOrigInput.value);
                                            const exchangeRate = parseFloat(exchangeRateSelect.value);

                                            if (!isNaN(priceOrig) && !isNaN(exchangeRate) && exchangeRate > 0) {
                                                const finalPrice = priceOrig * exchangeRate;
                                                priceLydInput.value = finalPrice.toFixed(2); // Format to 2 decimal places
                                            } else {
                                                priceLydInput.value = ''; // Clear if inputs are not valid numbers
                                            }
                                        }

                                        // Calculate when either the original price or exchange rate changes
                                        if (priceOrigInput) {
                                            priceOrigInput.addEventListener('input', calculateFinalPrice);
                                        }
                                        if (exchangeRateSelect) {
                                            exchangeRateSelect.addEventListener('change', calculateFinalPrice);
                                        }

                                        // Initial calculation on page load (if values are pre-filled)
                                        // calculateFinalPrice(); // Uncomment if needed
                                    </script>

                                    <!-- Add Font Awesome if you haven't already -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php include 'js.php'; ?>
</body>

</html>