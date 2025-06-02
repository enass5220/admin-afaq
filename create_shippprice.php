<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php'; // Assuming head.php contains meta tags, CSS links etc. 
    ?>
    <title>إضافة سعر شحن جديد</title>
</head>

<body >
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
                                    <h4 class="card-title">إضافة سعر شحن جديد</h4>
                                    <p class="card-description">أدخل تفاصيل سعر الشحن الجديد.</p>

                                    <form class="forms-sample" id="createform" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address">عنوان الشحن</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="address" aria-label="address"
                                                            name="address" placeholder="اختر عنوان الشحن" readonly data-bs-toggle="modal" data-bs-target="#userLookupModal">
                                                        <button type="button" id="lookupUserBtn" class="btn btn-outline-secondary"
                                                            data-bs-toggle="modal" data-bs-target="#userLookupModal">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Optional: Add a hidden input if you also want to store the user ID -->
                                                    <input type="hidden" id="add_id" name="add_id">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-3">

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked name="isactive" id="isactive" switch>
                                                    <label class="form-check-label" for="isactive">
                                                        مُفعل
                                                    </label>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="measurement_unit">الوزن / الحجم (مثال: 1 كجم)</label>
                                                    <div class="input-group">
                                                        <input type="number" min="0" class="form-control" id="nunit"
                                                            name="nunit" placeholder="أرقام فقط">

                                                        <input type="text" class="form-control" id="munit" name="munit" placeholder="مثال: kg أو cbm" required>
                                                    </div>
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
                                                        <option selected disabled>اختر نوع العملة</option>

                                                        <!-- Add other currencies as needed -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <button type="submit" class="btn btn-primary mr-2">إضافة السعر</button>
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
    <?php include 'js.php'; // Assuming js.php contains JavaScript files 
    ?>
    <script>
        $(document).ready(function() {
            fillSelectCurr();

            const $modalSearchUser = $('#userLookupModal');
            const $searchTermInput = $('#modalSearchTerm');
            const $searchResultsList = $('#modalSearchResultsList');
            const $searchPlaceholder = $('#modalSearchPlaceholder');
            const $loadingIndicator = $('#modalLoadingIndicator');
            const $mainUsernameInput = $('#address'); // The input field on your main form
            const $mainUserIdInput = $('#add_id'); // The hidden input for user ID on your main form

            // 1. Handle Search Button Click inside Modal
            $('#modalSearchBtn').on('click', function() {
                performSearch();
            });

            // Allow search on pressing Enter in the modal search input
            $searchTermInput.on('input', performSearch);

            function fillSelectCurr() {
                $.ajax({
                    url: 'server/select_exrate.php?curr=1',
                    type: 'GET',
                    contentType: 'application/json', // Telling the server we're sending JSON
                    dataType: 'json', // Expecting JSON response from the server
                    success: function(data) {
                        if (data && data.length > 0) {
                            data.forEach(function(rates) {
                                let item = `<option value="${rates.code}">${rates.name} (${rates.code})</option>`;
                                $('#currency').append(item);
                            });
                        } else if (data && data.error) {
                            console.log('خطأ: ' + data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error Status:', textStatus);
                        console.error('Error Thrown:', errorThrown);
                        console.error('Response Text:', jqXHR.responseText);
                    }
                });
            }

            function performSearch() {
                let term = $searchTermInput.val().trim();
                $searchResultsList.empty(); // Clear previous results
                $searchPlaceholder.hide(); // Hide placeholder
                if (term.length == 0) { // Minimum 1 char to search, adjust as needed
                    $searchPlaceholder.text('الرجاء إدخال حرف واحد على الأقل للبحث').show();
                    return;
                }

                $loadingIndicator.show();

                $.ajax({
                    url: 'server/search_address.php', // Path to your PHP script
                    type: 'GET',
                    data: {
                        term: term
                    },
                    dataType: 'json',
                    success: function(users) {
                        $loadingIndicator.hide();
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
                                    <small class="text-muted">`;
                                if (user.active) listItem += 'مُفعل';
                                else listItem += 'غير مُفعل';
                                listItem += ` | ${typ} | </small>
                                    <small class="text-muted">${user.address}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-success select-user-btn" data-bs-dismiss="modal"
                                        data-username="${user.country}"
                                        data-userid="${user.id}">
                                <i class="fa fa-check"></i> اختيار 
                                </button>
                            </li>`;
                                $searchResultsList.append(listItem);
                            });
                        } else if (users && users.error) {
                            $searchPlaceholder.text('خطأ: ' + users.error).show();
                        } else {
                            $searchPlaceholder.text('لم يتم العثور على عناوين (No users found).').show();
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
                if ($mainUserIdInput.length) { // Check if the hidden add_id input exists
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
                $searchPlaceholder.text('أدخل معايير البحث أعلاه .').show();
                $loadingIndicator.hide();
            });

            // Optional: Focus on search input when modal is shown
            $modalSearchUser.on('shown.bs.modal', function() {
                $searchTermInput.focus();
            });
            $('#createform').on('submit', function(event) {
                // Prevent the default form submission which would cause a page reload
                event.preventDefault();
                const rate = {
                    addr: $('#add_id').val(),
                    munit: $('#munit').val(),
                    price: $('#price').val(),
                    curr: $('#currency').val(),
                    nunit: parseFloat($('#nunit').val())
                };

                // The PHP API URL
                const apiUrl = 'server/create_shipprice.php'; // <-- CHANGE THIS TO YOUR API URL

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    contentType: 'application/json', // Telling the server we're sending JSON
                    data: JSON.stringify(rate), // Convert JavaScript object to JSON string
                    dataType: 'json', // Expecting JSON response from the server
                    success: function(response) {
                       // console.log('Success:', response);
                        Swal.fire({
                            title: "تم بنجاح!",
                            text: "تمت الإضافة بنجاح.",
                            icon: "success"
                        }).then((result) => {
                            $('#createform')[0].reset();
                            if (result.isConfirmed) {
                                window.location = "shipprices.php";
                            }
                        });
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
                        Swal.fire({
                            title: "خطأ!",
                            text: errorMessage,
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>