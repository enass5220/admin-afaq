<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php'; // Assuming head.php contains meta tags, CSS links etc. 
    ?>
    <title>إضافة سعر صرف جديد</title>
</head>

<body dir="rtl">
    <div class="container-scroller">
        <?php include 'navbar.php'; // Assuming navbar.php contains the top navigation bar 
        ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'; // Assuming sidebar.php contains the side navigation 
            ?>
            <div class="main-panel" style="direction: rtl;">
                <div class="content-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">إضافة سعر صرف جديد</h4>
                                    <p class="card-description">أدخل تفاصيل سعر الصرف الجديد مقابل الدينار الليبي.</p>

                                    <form class="forms-sample" method="POST" id="createform">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="currency_name">اسم العملة</label>
                                                    <input type="text" class="form-control" id="currency_name" name="currency_name" placeholder="مثال: الدولار الأمريكي" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="currency_code">رمز العملة</label>
                                                    <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="مثال: USD" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class=" col-md-5 form-group">
                                                <label for="value_vs_dinar">القيمة مقابل الدينار</label>
                                                <input type="number" step="0.001" class="form-control" id="value_vs_dinar" name="value_vs_dinar" placeholder="مثال: 5.600" required>
                                                <small class="form-text text-muted">أدخل قيمة العملة الأجنبية الواحدة بالدينار الليبي.</small>
                                            </div>
                                            <div class=" col-md-3 form-group">
                                                <label for="status">الحالة</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked name="isactive" id="isactive" switch>
                                                    <label class="form-check-label" for="isactive">
                                                        مُفعل
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2">إضافة السعر</button>
                                        <a href="exrates.php" class="btn btn-light">إلغاء</a> <!-- Adjust if your list page is named differently -->

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="responseMessage" class="message" style="display:none;"></div>

                    <?php include 'footer.php'; // Assuming footer.php contains footer content 
                    ?>
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
                const rate = {
                    name: $('#currency_name').val(),
                    code: $('#currency_code').val(),
                    dinar: parseFloat($('#value_vs_dinar').val()),
                    isactive: $('#isactive').prop('checked')
                };

                // The PHP API URL
                const apiUrl = 'server/create_exrate.php'; // <-- CHANGE THIS TO YOUR API URL

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
                                window.location = "exrates.php";
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