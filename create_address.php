<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php'; ?>
    <title>إضافة عنوان شحن جديد</title>
</head>

<body >
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper" >
                    <div class="row justify-content-center">
                        <div class="col-lg-9 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">إضافة عنوان شحن جديد</h4>
                                    <p class="card-description">أدخل تفاصيل عنوان الشحن.</p>

                                    <form class="forms-sample" id="createform" method="POST">
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
                                                    <select class="form-select" dir="ltr" id="type" name="shipping_type" required>
                                                        <option selected disabled>اختر نوع الشحن</option>
                                                        <option value="1">جوي</option>
                                                        <option value="2">بحري</option>
                                                        <option value="3">بري</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked name="isactive" id="isactive" switch>
                                                    <label class="form-check-label" for="isactive">
                                                        مُفعل
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address">عنوان الموقع التفصيلي</label>
                                            <textarea class="form-control" id="address" name="location_address" rows="4" placeholder="مثال: شارع الجمهورية, طرابلس, مستودع رقم 5" required></textarea>
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
    <script>
        $(document).ready(function() {

            $('#createform').on('submit', function(event) {
                // Prevent the default form submission which would cause a page reload
                event.preventDefault();
                const adrs = {
                    type: parseInt($('#type').val()) ,
                    address: $('#address').val(),
                    country: $('#country').val(),
                    isactive: $('#isactive').prop('checked')
                };

                // The PHP API URL
                const apiUrl = 'server/create_address.php'; // <-- CHANGE THIS TO YOUR API URL

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    contentType: 'application/json', // Telling the server we're sending JSON
                    data: JSON.stringify(adrs), // Convert JavaScript object to JSON string
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
                                window.location = "shipaddress.php";
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