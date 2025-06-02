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
                                    <form class="forms-sample p-3 border rounded shadow-sm" id="shipmentForm" method="post"> <!-- Added padding, border, and shadow for visual structure -->

                                        <h5 class="mb-4 border-bottom pb-2">معلومات الزبون والطلب</h5> <!-- Section Title -->

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="username" class="form-label">اختر الزبون</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="username" aria-label="Username"
                                                        name="username" placeholder="كود شحن الزبون" readonly data-bs-toggle="modal" data-bs-target="#userLookupModal">
                                                    <button type="button" id="lookupUserBtn" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal" data-bs-target="#userLookupModal">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                                <!-- Optional: Add a hidden input if you also want to store the user ID -->
                                                <input type="hidden" id="user_id" name="user_id">

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="orderno" class="form-label">رقم الطلب (Order Number)</label>
                                                <input type="text" dir="rtl" required class="form-control" id="orderno" aria-label="Order Number" name="orderno" placeholder="رقم الطلب في shein">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="trackno" class="form-label">رقم الشحن (Tracking Number)</label>
                                                <input type="text" dir="rtl" class="form-control" id="trackno" aria-label="Tracking Number" name="trackno" placeholder="رقم الشحن في shein (اختياري)">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="olink" class="form-label">رابط الطلبية / السلة</label>
                                                <input type="url" dir="rtl" required class="form-control" id="olink" aria-label="Order link" name="olink" placeholder="https://...">
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
                                                    <span class="input-group-text">
                                                        <select class="form-select form-select-sm">
                                                            <option>دولار $</option>
                                                        </select>
                                                    </span> <!-- Example currency, adjust as needed -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">

                                                <label for="exchange_rate" class="form-label">سعر الصرف</label>
                                                <select class="form-select" dir="rtl" id="exchange_rate" name="exchange_rate" required aria-label="Exchange Rate">
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
                                            <div class="col-md-6 mb-3">
                                                <label for="shipment_method" class="form-label">طريقة الشحن</label>
                                                <select dir="rtl" class="form-select" id="shipment_method" name="shipment_method" dir="rtl" required>
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
                                                <select dir="rtl" class="form-select" id="ostate" name="ostate">
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

                    <div id="responseMessage" class="message" style="display:none;"></div>

                    <?php include 'footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- User Lookup Modal -->
    <div class="modal fade" id="userLookupModal" tabindex="-1" aria-labelledby="userLookupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg for a wider modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLookupModalLabel">بحث عن مستخدم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="modalSearchTerm" placeholder="ابحث بالاسم أو اسم المستخدم">
                            <button class="btn btn-primary" type="button" id="modalSearchBtn">بحث </button>
                        </div>
                    </div>
                    <div id="modalSearchResultsContainer" style="max-height: 300px; overflow-y: auto;">
                        <!-- Search results will be loaded here -->
                        <p class="text-muted text-center" id="modalSearchPlaceholder">اكتب للبحث</p>
                        <ul class="list-group" id="modalSearchResultsList">
                        </ul>
                        <div id="modalLoadingIndicator" class="text-center" style="display:none;">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php include 'js.php'; ?>
    <script>
        $(document).ready(function() {
            // Optional: Basic client-side calculation for total_price_lyd display
            // function calculateLydPrice() {
            //     const priceOrig = parseFloat($('#total_price_orig').val());
            //     const rate = parseFloat($('#exchange_rate').val());
            //     if (!isNaN(priceOrig) && !isNaN(rate)) {
            //         $('#total_price_lyd').val((priceOrig * rate).toFixed(2));
            //     } else {
            //         $('#total_price_lyd').val('');
            //     }
            // }
            // $('#total_price_orig, #exchange_rate').on('input', calculateLydPrice);
            // calculateLydPrice(); // Initial calculation

            $('#shipmentForm').on('submit', function(event) {
                // Prevent the default form submission which would cause a page reload
                event.preventDefault();

                // Show loading state (optional)
                $('#responseMessage').hide().removeClass('success error').empty();
                const $submitButton = $(this).find('button[type="submit"]');
                $submitButton.prop('disabled', true).text('Submitting...');

                // Collect form data into an object
                // The API expects numbers for price and rate, so ensure they are parsed
                const shipmentData = {
                    username: $('#username').val(),
                    orderno: $('#orderno').val(),
                    olink: $('#olink').val(),
                    total_price_orig: parseFloat($('#total_price_orig').val()),
                    exchange_rate: parseFloat($('#exchange_rate').val()),
                    shipment_method: $('#shipment_method').val(),
                    // Optional fields:
                    trackno: $('#trackno').val() || null, // Send null if empty
                    currency_orig: $('#currency_orig').val() || 'USD',
                    // total_price_lyd: parseFloat($('#total_price_lyd').val()), // Server calculates this, but you can send if needed
                    ostate: $('#ostate').val() || '1',
                    payment_status: $('#payment_status').val() || 'pending'
                };

                // The PHP API URL
                const apiUrl = 'server/create_shipment.php'; // <-- CHANGE THIS TO YOUR API URL

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    contentType: 'application/json', // Telling the server we're sending JSON
                    data: JSON.stringify(shipmentData), // Convert JavaScript object to JSON string
                    dataType: 'json', // Expecting JSON response from the server
                    success: function(response) {
                        console.log('Success:', response);
                        $('#responseMessage')
                            .removeClass('error')
                            .addClass('success')
                            .html(`<strong>Success!</strong> ${response.message}` + (response.shipmentId ? ` Shipment ID: ${response.shipmentId}` : ''))
                            .show();
                        // Optionally, reset the form
                        // $('#shipmentForm')[0].reset();
                        // calculateLydPrice(); // Recalculate if form is reset
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error Status:', textStatus);
                        console.error('Error Thrown:', errorThrown);
                        console.error('Response Text:', jqXHR.responseText);

                        let errorMessage = 'An error occurred.';
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        } else if (jqXHR.responseText) {
                            try {
                                // Try to parse if it's JSON but content-type was wrong
                                const errResponse = JSON.parse(jqXHR.responseText);
                                if (errResponse.message) errorMessage = errResponse.message;
                            } catch (e) {
                                // Not JSON, or malformed
                                if (jqXHR.status === 0) {
                                    errorMessage = 'Could not connect to the server. Please check the API URL and if the server is running.';
                                } else {
                                    errorMessage = `Error ${jqXHR.status}: ${errorThrown}`;
                                }
                            }
                        }

                        $('#responseMessage')
                            .removeClass('success')
                            .addClass('error')
                            .html(`<strong>Error:</strong> ${errorMessage}`)
                            .show();
                    },
                    complete: function() {
                        // Re-enable button
                        $submitButton.prop('disabled', false).text('Create Shipment');
                    }
                });
            });

            const $modalSearchUser = $('#userLookupModal');
            const $searchTermInput = $('#modalSearchTerm');
            const $searchResultsList = $('#modalSearchResultsList');
            const $searchPlaceholder = $('#modalSearchPlaceholder');
            const $loadingIndicator = $('#modalLoadingIndicator');
            const $mainUsernameInput = $('#username'); // The input field on your main form
            const $mainUserIdInput = $('#user_id'); // The hidden input for user ID on your main form

            // 1. Handle Search Button Click inside Modal
            $('#modalSearchBtn').on('click', function() {
                performSearch();
            });

            // Allow search on pressing Enter in the modal search input
            $searchTermInput.on('input', performSearch);

            function performSearch() {
                const term = $searchTermInput.val().trim();
                $searchResultsList.empty(); // Clear previous results
                $searchPlaceholder.hide(); // Hide placeholder
                if (term.length == 0) { // Minimum 1 char to search, adjust as needed
                    $searchPlaceholder.text('الرجاء إدخال حرف واحد على الأقل للبحث').show();
                    return;
                }

                $loadingIndicator.show();

                $.ajax({
                    url: 'server/search_users.php', // Path to your PHP script
                    type: 'GET',
                    data: {
                        term: term
                    },
                    dataType: 'json',
                    success: function(users) {
                        $loadingIndicator.hide();
                        if (users && users.length > 0) {
                            users.forEach(function(user) {
                                // Adjust based on your user object properties from PHP
                                const fullName = user.name || 'N/A';
                                const listItem = `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${user.name}</strong> <br>
                                    <small class="text-muted">كود: ${user.code}</small>
                                    <small class="text-muted">هاتف: ${user.phone}</small>
                                </div>
                                <button class="btn btn-sm btn-success select-user-btn" data-bs-dismiss="modal"
                                        data-username="${user.code}"
                                        data-phone=" ${user.phone}"
                                        data-userid="${user.id}">
                                <i class="fa fa-check"></i> اختيار 
                                </button>
                            </li>`;
                                $searchResultsList.append(listItem);
                            });
                        } else if (users && users.error) {
                            $searchPlaceholder.text('خطأ: ' + users.error).show();
                        } else {
                            $searchPlaceholder.text('لم يتم العثور على مستخدمين (No users found).').show();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $loadingIndicator.hide();
                        console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                        $searchPlaceholder.text('حدث خطأ أثناء البحث. حاول مرة أخرى. (Error during search. Please try again.)').show();
                    }
                });
            }

            // 2. Handle User Selection from Modal Results (Event Delegation)
            $searchResultsList.on('click', '.select-user-btn', function() {
                const selectedUsername = $(this).data('username');
                const selectedUserId = $(this).data('userid');
                const selectedPhone = $(this).data('phone');

                $mainUsernameInput.val(selectedUsername);
                if ($mainUserIdInput.length) { // Check if the hidden user_id input exists
                    $mainUserIdInput.val(selectedUserId);
                }

                // Optionally, trigger a change event if other parts of your page depend on it
                $mainUsernameInput.trigger('change');

                $modalSearchUser.modal('toggle'); // Hide the modal using Bootstrap's JavaScript API
            });

            // 3. Optional: Clear search results when modal is closed or re-opened
            $modalSearchUser.on('hidden.bs.modal', function() {
                $searchTermInput.val(''); // Clear search term
                $searchResultsList.empty(); // Clear results
                $searchPlaceholder.text('أدخل معايير البحث أعلاه (Enter search criteria above).').show();
                $loadingIndicator.hide();
            });

            // Optional: Focus on search input when modal is shown
            $modalSearchUser.on('shown.bs.modal', function() {
                $searchTermInput.focus();
            });

        });
    </script>
</body>

</html>