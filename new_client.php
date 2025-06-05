<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الزبائن | زبون جديد</title>
</head>

<body>
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row justify-content-center">
                        <div class="col-8" style="direction: rtl;">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"> زبون جديد</h4>
                                    <p class="card-description"> انشاء حساب لزبون جديد </p>
                                    <form class="forms-sample" id="registrationForm" method="post">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="username">اسم الزبون كامل</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="اسم المستخدم">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="code">كود الشحن</label>
                                                <input type="text" class="form-control" id="code" name="code" placeholder="كود الشحن">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="email">البريد الالكتروني</label>
                                                <input type="email" class="form-control" id="email" placeholder="البريد الالكتروني" name="email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">رقم الهاتف </label>
                                                <input type="phone" class="form-control" id="phone" placeholder="رقم الهاتف " name="phone">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputPassword1">كلمة المرور</label>
                                                <input type="password" class="form-control" placeholder="كلمة المرور" name="password1" id="password1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password2">تأكيد كلمة المرور</label>
                                                <input type="password" class="form-control" name="password2" id="password2" placeholder="اعد كتابة كلمة المرور">
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">تسجيل</button>
                                        <button class="btn btn-light">إلغاء</button>
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
    $('#registrationForm').on('submit', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Client-side validation for password match
        const password = $('#password1').val();
        const password2 = $('#password2').val();

        if (password !== password2) {
            Swal.fire({
                title: "خطأ في كلمة المرور!",
                text: "كلمتا المرور غير متطابقتين.",
                icon: "error"
            });
            return; // Stop submission
        }

        // Optional: Disable button to prevent multiple clicks
        const $submitButton = $('#registrationForm').find('button[type="submit"]');
        const originalButtonText = $submitButton.html();
        $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري التسجيل...');


        // Collect form data using .serialize() which creates a URL-encoded string
        // This is suitable for Content-Type: application/x-www-form-urlencoded (default for $.ajax POST)
        const formData = $('#registrationForm').serialize();

        // The PHP API URL
        const apiUrl = 'server/create_client.php'; // <-- CHANGE THIS TO YOUR API URL

        $.ajax({
            url: apiUrl,
            type: 'POST',
            data: formData, // Send serialized form data
            dataType: 'json', // Expecting JSON response from the server
            success: function(response) {
                $submitButton.prop('disabled', false).html(originalButtonText); // Re-enable button

                if (response.status === 'success') {
                    Swal.fire({
                        title: "تم بنجاح!",
                        text: response.message,
                        icon: "success"
                    }).then((result) => {
                        $('#registrationForm')[0].reset(); // Reset the form fields
                        if (result.isConfirmed) {
                             window.location = "clients.php"; // Example redirect
                        }
                    });
                } else {
                    // Handle specific errors if your PHP sends them
                    let errorMessage = response.message || 'حدث خطأ غير متوقع.';
                    if (response.errors) {
                        errorMessage += '<br><ul style="text-align: right; list-style-type: none; padding-right: 0;">';
                        for (const key in response.errors) {alert(response.errors[key]);
                            errorMessage += `<li>${response.errors[key]}</li>`;
                        }
                        errorMessage += '</ul>';
                    }
                    Swal.fire({
                        title: "خطأ!",
                        html: errorMessage,
                        icon: "error"
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $submitButton.prop('disabled', false).html(originalButtonText); // Re-enable button
                console.error('Error Status:', textStatus);
                console.error('Error Thrown:', errorThrown);
                console.error('Response Text:', jqXHR.responseText);

                let errorMessage = 'فشل الاتصال بالخادم.';
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    errorMessage = jqXHR.responseJSON.message;
                } else if (jqXHR.responseText) {
                    try {
                        const errResponse = JSON.parse(jqXHR.responseText);
                        if (errResponse.message) errorMessage = errResponse.message;
                    } catch (e) {
                        if (jqXHR.status === 0) {
                            errorMessage = 'لا يمكن الاتصال بالخادم. الرجاء التحقق من عنوان API وما إذا كان الخادم يعمل.';
                        } else {
                           errorMessage = `خطأ ${jqXHR.status}: ${errorThrown || 'حدث خطأ ما'}`;
                        }
                    }
                }
                Swal.fire({
                    title: "خطأ في الاتصال!",
                    text: errorMessage,
                    icon: "error"
                });
                alert(errorMessage);
            }
        });
    });
});
    </script>
</body>

</html>