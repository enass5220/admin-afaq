<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الشحنات | تحديث شحنة </title>
</head>

<body>
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title">تحديث شحنة </h4>
                                            <p class="card-description"> تحديث طلبية
                                                <span id="ordercode" class="fw-bold">#</span> | الزبون <span id="customer" class="fw-bold"></span>
                                            </p>
                                        </div>
                                        <div>
                                            <button class="btn btn-info" 
                                                            data-bs-toggle="modal" data-bs-target="#paymentInfo">
                                                <i class="mdi mdi-plus btn-icon-prepend"></i> تفاصيل الدفع 
                                            </button>
                                        </div>
                                    </div>
                                    <form class="forms-sample p-3 border rounded shadow-sm" id="shipmentForm" method="post"> <!-- Added padding, border, and shadow for visual structure -->

                                        <h5 class="mb-4 border-bottom pb-2">معلومات الزبون والطلب</h5> <!-- Section Title -->
                                        <input type="hidden" name="order_id" id="order_id" value="<?php echo $_GET['id']; ?>"> <!-- Hidden field for order ID -->
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="orderno" class="form-label">رقم الطلب (Order Number)</label>
                                                <input type="text" required class="form-control" id="orderno" aria-label="Order Number" name="orderno" placeholder="رقم الطلب في shein">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="trackno" class="form-label">رقم الشحن (Tracking Number)</label>
                                                <input type="text" class="form-control" id="trackno" aria-label="Tracking Number" name="trackno" placeholder="رقم الشحن في shein (اختياري)">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="olink" class="form-label">رابط الطلبية / السلة</label>
                                                <input type="url" required class="form-control" id="olink" aria-label="Order link" name="olink" placeholder="https://...">
                                            </div>
                                        </div>
                                        <h5 class="mb-4 border-bottom pb-2">تفاصيل السعر</h5> <!-- Section Title -->

                                        <!-- Price Information Section -->
                                        <div class="row mb-3 align-items-end"> <!-- align-items-end helps align labels/inputs vertically if heights differ slightly -->
                                            <div class="col-md-4 mb-3">
                                                <label for="total_price_orig" class="form-label">السعر الإجمالي (العملة الأصلية)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" required class="form-control" min="0" id="total_price_orig" name="total_price_orig" placeholder="150.50" aria-label="اجمالي السعر بالدولار">
                                                    <span class="input-group-text">
                                                        <select class="form-select form-select-sm" id="currency" name="currency">

                                                        </select>
                                                    </span> <!-- Example currency, adjust as needed -->
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">

                                                <label for="exchange_rate" class="form-label">سعر الصرف</label>
                                                <select class="form-select" id="exchange_rate" name="exchange_rate" required aria-label="Exchange Rate" dir="rtl">
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="total_price_lyd" class="form-label">السعر النهائي (دينار ليبي)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" class="form-control" id="total_price_lyd" min="0" name="total_price_lyd" placeholder="يتم حسابه تلقائياً" aria-label="Final Total Price LYD" readonly> <!-- Make readonly if calculated -->
                                                    <span class="input-group-text">د.ل.</span>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">سيتم تحديث السعر الاجمالي بناءاً على سعر الصرف.</small>

                                        </div>
                                        <div class="row mb-3 align-items-end">
                                        </div>
                                        <h5 class="mb-4 border-bottom pb-2">تفاصيل الشحن</h5> <!-- Section Title -->
                                        <div class="row mb-3 align-items-end">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group mb-0">
                                                    <label for="address1">عنوان الشحن</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="address1" aria-label="address1"
                                                            name="address1" placeholder="اختر عنوان الشحن" readonly data-bs-toggle="modal" data-bs-target="#userLookupModal1">
                                                        <button type="button" id="lookupUserBtn" class="btn btn-outline-secondary"
                                                            data-bs-toggle="modal" data-bs-target="#userLookupModal1">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Optional: Add a hidden input if you also want to store the user ID -->
                                                    <input type="hidden" id="add_id1" name="add_id1">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="ostate" class="form-label">حالة الشحنة (للمشرف)</label> <!-- Clarified label -->
                                                <select dir="ltr" class="form-select" id="ostate" name="ostate">
                                                    <option value="1">تم الانشاء</option>
                                                    <option value="2">وصلت إلى المخزن الخارجي</option>
                                                    <option value="3">وصلت إلى مخزن ليبيا</option>
                                                    <option value="4">جاهز للتسليم</option>
                                                    <option value="5">تم التسليم</option>
                                                    <!-- Add more states if needed -->
                                                </select>
                                                <!-- This field might typically be disabled for the user and only editable by admin -->
                                            </div>
                                        </div>
                                        <!-- End Price Information Section -->

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="total_price_lyd" class="form-label">وزن الشحنة</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0" class="form-control" id="weight" name="weight"
                                                        placeholder="وزن الشحنة بالأرقام" aria-label="Total shipment weight in numbers">
                                                    <span class="input-group-text">
                                                        <select class="form-select form-select-sm" id="unit" name="unit">
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="total_price_lyd" class="form-label">قيمة الشحن (بالعملة الأجنبية )</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0" class="form-control" id="total_ship_curr" name="total_ship_curr" placeholder="يتم حسابه تلقائياً" aria-label="Final Total Shipping Price" readonly> <!-- Make readonly if calculated -->
                                                    <span class="input-group-text" id="ship_curr"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="total_price_lyd" class="form-label">قيمة الشحن (دينار ليبي)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0" class="form-control" id="total_ship_lyd" name="total_ship_lyd" placeholder="يتم حسابه تلقائياً" aria-label="Final Total ShippingPrice LYD" readonly> <!-- Make readonly if calculated -->
                                                    <span class="input-group-text">د.ل.</span>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">سيتم تحديث قيمة الشحن بناءاً على سعر الشحن على العنوان.</small>

                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-end"> <!-- Align buttons to the right -->
                                            <button type="button" class="btn btn-light me-3">إلغاء</button> <!-- Added margin -->
                                            <button type="submit" class="btn btn-primary">تعديل الشحنة</button> <!-- Changed text slightly -->
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
    <div class="modal fade" id="userLookupModal1" tabindex="-1" aria-labelledby="userLookupModalLabel" aria-hidden="true">
        <div class="modal-dialog "> <!-- modal-lg for a wider modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLookupModalLabel">بحث عن عنوان</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="modalSearchTerm1" placeholder="ابحث بنص العنوان أو البلد">
                            <button class="btn btn-primary" type="button" id="modalSearchBtn1">بحث </button>
                        </div>
                    </div>
                    <div id="modalSearchResultsContainer" style="max-height: 300px; overflow-y: auto;">
                        <!-- Search results will be loaded here -->
                        <p class="text-muted text-center" id="modalSearchPlaceholder1">اكتب للبحث</p>
                        <ul class="list-group" id="modalSearchResultsList1">
                        </ul>
                        <div id="modalLoadingIndicator1" class="text-center" style="display:none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">جاري التحميل...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <!-- =================================================================
     PAYMENT DETAILS MODAL 
     ================================================================== -->
<div class="modal fade" id="paymentInfo" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">تفاصيل الدفع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" >
                    <input type="hidden" id="receipt_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="receipt_number" class="form-label">رقم الإيصال</label>
                            <input type="text" class="form-control" id="receipt_number" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="payment_date" class="form-label">تاريخ الدفع</label>
                            <input type="date" class="form-control" id="payment_date" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="total_amount" class="form-label">المبلغ الإجمالي</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="total_amount" >
                                <span class="input-group-text" id="payment_curr_display"></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="total_amount_paid" class="form-label">المبلغ المدفوع</label>
                            <input type="number" class="form-control" id="total_amount_paid" >
                        </div>
                         <div class="col-md-4 mb-3">
                            <label for="payment_method_display" class="form-label">طريقة الدفع</label>
                            <input type="text" class="form-control" id="payment_method_display" >
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_paid_display" >
                                <label class="form-check-label" for="is_paid_display">تم الدفع بالكامل</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" ><i class="fa fa-print"></i> حفظ</button>
            </div>
        </div>
    </div>
</div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php include 'js.php'; ?>
    <script>
        $(document).ready(function() {
            let orderid = $('#order_id').val();
            fillSelectCurr(1);
            $('#total_price_orig').on('input', calculateLydPrice);
            $('#weight').on('input', calculateWeightPrice);
            $('#exchange_rate').on('change', calculateLydPrice); // <--- THIS IS THE KEY CHANGE

            $('#currency').change(function() {
                let vall = $(this).val(); // Get selected currency code
                if (vall && vall !== "-- اختر العملة الأصلية --") { // Ensure a valid currency is selected
                    fillSelectCurr(vall); // This will populate #exchange_rate
                    // and its success callback can trigger calculateLydPrice
                    // or the .change() on #exchange_rate will be triggered
                } else {
                    // Clear exchange rate and LYD price if no valid currency is selected
                    $('#exchange_rate').empty().append('<option selected disabled value="">-- اختر العملة أولاً --</option>');
                    calculateLydPrice(); // This will clear total_price_lyd because rate will be NaN
                }
            });

            function calculateLydPrice() {
                const priceOrig = parseFloat($('#total_price_orig').val());
                // Get the value from the selected option of the #exchange_rate dropdown
                const rate = parseFloat($('#exchange_rate').val());

                console.log("Calculating LYD Price: Original Price =", priceOrig, "Rate =", rate); // For debugging

                if (!isNaN(priceOrig) && !isNaN(rate) && rate > 0) { // Added rate > 0 check
                    $('#total_price_lyd').val((priceOrig * rate).toFixed(2));
                } else {
                    $('#total_price_lyd').val('');
                }
            }

            function getShippingPrices(idd) {
                $.ajax({
                    url: 'server/select_shipprice.php',
                    type: 'GET',
                    data: {
                        add: idd
                    },
                    dataType: 'json',
                    success: function(data) {
                        let idd = '#unit';
                        let i = 'selected';
                        if (data && data.length > 0) {
                            $(idd).empty();
                            data.forEach(function(rates) {
                                let item = `<option value="${rates.id}" ${i} 
                                data-unit="${rates.unit_number}" data-price="${rates.price_per_unit}">
                                ${rates.unitt}=${rates.curr}</option>`;
                                $(idd).append(item);
                                i = '';
                            });
                        } else {
                            $(idd).empty().append('<option  disabled value="">-- لا توجد بيانات --</option>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown, jqXHR.responseText);
                    }
                });


            }

            function fillSelectCurr(typ) {
                $.ajax({
                    url: 'server/select_exrate.php?curr=' + typ,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.length > 0) {
                            let idd = '#currency';
                            if (typ == 1) {
                                $(idd).empty();
                                $(idd).append('<option disabled>-- اختر العملة الأصلية --</option>');
                                data.forEach(function(rates) {
                                    let item = `<option value="${rates.code}">${rates.name} (${rates.code})</option>`;
                                    $(idd).append(item);
                                });
                            } else {
                                idd = '#exchange_rate';
                                $(idd).empty();
                                $(idd).append('<option disabled value="">-- اختر سعر الصرف --</option>');
                                data.forEach(function(rates) {
                                    let act = '';
                                    if (rates.active) {
                                        act = "مُفعل";
                                    } else act = "غير مُفعل"
                                    let item = `
                                    <option value='${rates.rate}' data-id='${rates.id}'>1 ${rates.name}=${rates.rate} د.ل. (${act})</option>`;
                                    $(idd).append(item);
                                });
                            }
                            $(idd).val($(idd + " option:eq(1)").val()).change();
                            $(idd + ' option:eq(1)').attr('selected', 'selected');

                            if (typ != 1 && $(idd).find("option[value!='']").length > 0) {
                                calculateLydPrice();
                            }


                        } else if (data && data.error) {
                            console.log('خطأ: ' + data.error);
                            if (typ != 1) {
                                $('#exchange_rate').empty().append('<option  disabled value="">-- لا توجد أسعار صرف --</option>');
                                calculateLydPrice();
                            }
                        } else {
                            if (typ != 1) {
                                $('#exchange_rate').empty().append('<option  disabled value="">-- لا توجد أسعار صرف --</option>');
                                calculateLydPrice();
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error Status:', textStatus);
                        console.error('Error Thrown:', errorThrown);
                        console.error('Response Text:', jqXHR.responseText);
                        if (typ != 1) {
                            $('#exchange_rate').empty().append('<option  disabled value="">-- خطأ في التحميل --</option>');
                            calculateLydPrice();
                        }
                    }
                });
            }

            function calculateWeightPrice() {
                const weight = parseFloat($('#weight').val());
                const unit = $('#unit').find(':selected').data('unit');
                const pricePerUnit = parseFloat($('#unit').find(':selected').data('price'));
                let calced = weight / unit;
                if (!isNaN(calced) && !isNaN(pricePerUnit) && calced > 0 && pricePerUnit > 0) {
                    const totalShippingPrice = calced * pricePerUnit;
                    $('#total_ship_curr').val(totalShippingPrice.toFixed(2));
                    $('#total_ship_lyd').val((totalShippingPrice * parseFloat($('#exchange_rate').val())).toFixed(3));
                    $('#ship_curr').text($('#currency').val());
                } else {
                    $('#total_ship_curr').val('');
                    $('#total_ship_lyd').val('');
                }
            }
            $.ajax({
                url: 'server/get_orders.php?',
                type: 'GET',
                data: {
                    id: orderid
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        // Populate the table with new data
                        $.each(response.data, function(index, order) {
                            let typ = '';
                            switch (order.typ) {
                                case 1:
                                    typ = 'جوي'
                                    break;
                                case 2:
                                    typ = 'بحري'
                                    break;
                                case 3:
                                    typ = 'بري'
                                    break;
                            }
                            $('#customer').text(order.full_name);
                            $('#ordercode').text('#' + order.order_code);
                            $('#ostate').val(order.order_status);
                            $('#user').text(order.full_name);
                            $('#orderno').val(order.order_number);
                            $('#trackno').val(order.tracking_number);
                            $('#olink').val(order.shein_link);
                            $('#add_id1').val(order.shipadd_id);
                            $('#address1').val(order.country + ' - ' + typ);
                            $('#total_price_orig').val(parseFloat(order.total_cost_usd).toFixed(2));
                            // $('#currency').val(order.curr_short);
                            $('#currency').val(order.curr_short).change();
                            $('#exchange_rate').val(order.exchange_rate_id).change();
                            // $(idd).val($(idd + " option value='"+).val()).change()
                            $('#exchange_rate').val(order.exchange_rate_id);
                            getShippingPrices(order.shipadd_id);
                            $('#total_price_lyd').val(parseFloat(order.total_cost_lyd).toFixed(3));
                            $('#weight').val(order.shipping_weight != null && !isNaN(parseFloat(order.shipping_weight)) ? parseFloat(order.shipping_weight) : '');
                            $('#total_ship_lyd').val(order.weight_price_lyd);
                            $('#total_ship_curr').val(order.weight_price_total);
                            $('#unit').val(order.weightprice_id);

                        });
                    } else {
                        $('#ordercode').text('لا توجد بيانات للطلب المحدد.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    tableBody.html('<tr><td colspan="8" class="text-center text-danger">حدث خطأ أثناء تحميل البيانات.</td></tr>');
                    console.error('AJAX Error:', textStatus, errorThrown, jqXHR.responseText);
                }
            });

        });

        $('#shipmentForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default browser form submission

            const form = $(this);
            const submitButton = form.find('button[type="submit"]');
            const originalButtonText = submitButton.html();

            // --- START: THE KEY CHANGE ---
            // Get the data-id from the selected exchange rate option
            const exchangeRateId = $('#exchange_rate').find(':selected').data('id');

            // Check if a valid rate ID was found
            if (!exchangeRateId) {
                alert('يرجى اختيار سعر صرف صالح.');
                return; // Stop the submission
            }

            // Dynamically create a hidden input to hold the exchange rate ID
            // This will be picked up by .serialize()
            const hiddenInput = $('<input>').attr({
                type: 'hidden',
                name: 'exchange_rate_id', // The name the PHP script will look for
                value: exchangeRateId
            });
            form.append(hiddenInput);
            // --- END: THE KEY CHANGE ---

            // Disable button and show a loading state
            submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جارٍ التحديث...');

            // Serialize form data (it will now include our hidden input)
            const formData = form.serialize();

            // IMPORTANT: Remove the temporary hidden input after serializing
            hiddenInput.remove();

            $.ajax({
                url: 'server/update_order_action.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "تم بنجاح!",
                            text: "تمت الإضافة بنجاح.",
                            icon: "success"
                        }).then((result) => {
                            $('#shipmentForm')[0].reset();
                            if (result.isConfirmed) {
                                window.location = "orders.php";
                            }
                        });
                    } else {
                        let errorMessage = response.message || 'An unknown error occurred.';
                        if (response.errors) {
                            errorMessage += '\n\n' + response.errors.join('\n');
                        }
                        alert('فشل التحديث:\n' + errorMessage);
                        submitButton.prop('disabled', false).html(originalButtonText);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                    alert('حدث خطأ فادح في الشبكة أو الخادم. يرجى مراجعة وحدة التحكم لمزيد من التفاصيل.');
                    submitButton.prop('disabled', false).html(originalButtonText);
                }
            });
        });
        /// start address search
        const $modalSearchUser1 = $('#userLookupModal1');
        const $searchTermInput1 = $('#modalSearchTerm1');
        const $searchResultsList1 = $('#modalSearchResultsList1');
        const $searchPlaceholder1 = $('#modalSearchPlaceholder1');
        const $loadingIndicator1 = $('#modalLoadingIndicator1');
        const $mainUsernameInput1 = $('#address1'); // The input field on your main form
        const $mainUserIdInput1 = $('#add_id1'); // The hidden input for user ID on your main form

        // 1. Handle Search Button Click inside Modal
        $('#modalSearchBtn1').on('click', function() {
            performSearch1();
        });

        // Allow search on pressing Enter in the modal search input
        $searchTermInput1.on('input', performSearch1);

        function performSearch1() {
            let term = $searchTermInput1.val().trim();
            $searchResultsList1.empty(); // Clear previous results
            $searchPlaceholder1.hide(); // Hide placeholder
            if (term.length == 0) { // Minimum 1 char to search, adjust as needed
                $searchPlaceholder1.text('الرجاء إدخال حرف واحد على الأقل للبحث').show();
                return;
            }

            $loadingIndicator1.show();

            $.ajax({
                url: 'server/search_address.php', // Path to your PHP script
                type: 'GET',
                data: {
                    term: term
                },
                dataType: 'json',
                success: function(users) {
                    $loadingIndicator1.hide();
                    if (users && users.length > 0) {
                        users.forEach(function(user) {
                            let typ = '';
                            switch (user.type) {
                                case 1:
                                    typ = 'جوي'
                                    break;
                                case 2:
                                    typ = 'بحري'
                                    break;
                                case 3:
                                    typ = 'بري'
                                    break;
                            }
                            let listItem = `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${user.country}</strong> <br>
                                    `;
                            if (user.active) listItem += '<small class="text-info">مُفعل';
                            else listItem += '<small class="text-secondary">غير مُفعل';
                            listItem += ` | ${typ} | </small>
                                    <small class="text-muted">${user.address}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-success select-user-btn" data-bs-dismiss="modal"
                                        data-username="${user.country}"
                                        data-userid="${user.id}">
                                <i class="fa fa-check"></i> اختيار 
                                </button>
                            </li>`;
                            $searchResultsList1.append(listItem);
                        });
                    } else if (users && users.error) {
                        $searchPlaceholder1.text('خطأ: ' + users.error).show();
                    } else {
                        $searchPlaceholder1.text('لم يتم العثور على عناوين (No users found).').show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $loadingIndicator1.hide();
                    console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                    $searchPlaceholder1.text('حدث خطأ أثناء البحث. حاول مرة أخرى. (Error during search. Please try again.)').show();
                }
            });
        }

        // 2. Handle User Selection from Modal Results (Event Delegation)
        $searchResultsList1.on('click', '.select-user-btn', function() {
            const selectedUsername = $(this).data('username');
            const selectedUserId = $(this).data('userid');
            const selectedPhone = $(this).data('phone');

            $mainUsernameInput1.val(selectedUsername);
            if ($mainUserIdInput1.length) { // Check if the hidden add_id1 input exists
                $mainUserIdInput1.val(selectedUserId);
            }

            // Optionally, trigger a change event if other parts of your page depend on it
            $mainUsernameInput1.trigger('change');

            $modalSearchUser1.modal('toggle'); // Hide the modal using Bootstrap's JavaScript API
        });

        // 3. Optional: Clear search results when modal is closed or re-opened
        $modalSearchUser1.on('hidden.bs.modal', function() {
            $searchTermInput1.val(''); // Clear search term
            $searchResultsList1.empty(); // Clear results
            $searchPlaceholder1.text('أدخل معايير البحث أعلاه .').show();
            $loadingIndicator1.hide();
        });

        // Optional: Focus on search input when modal is shown
        $modalSearchUser1.on('shown.bs.modal', function() {
            $searchTermInput1.focus();
        });
    </script>
</body>

</html>