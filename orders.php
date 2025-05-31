<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الشحنات | جميع الطلبات</title>
    <style>
        /* Optional: Custom styles for better table readability or specific needs */
        .table th,
        .table td {
            vertical-align: middle;
            /* Align content vertically in table cells */
        }

        .actions-btn-group .btn {
            margin-right: 5px;
            /* Space between action buttons */
        }

        .actions-btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card" style="direction: rtl;">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="card-title">قائمة جميع الطلبات</h4>
                                    <p class="card-description pb-3"> عرض وتصفية طلبات الشحنات
                        </p> 
                      </div>
                      <div>
                          <a href="create_order.php" class="btn btn-primary btn-icon-text">
                              <i class="mdi mdi-plus btn-icon-prepend"></i>شحنة جديدة
                          </a>
                      </div>
                    </div>
                                    <!-- Filter Bar -->
                                    <form class="forms-sample p-3 border rounded shadow-sm mb-4 bg-light">
                                        <div class="row align-items-end">
                                            <div class="col-md-4 mb-3">
                                                <label for="filterSearch" class="form-label">بحث</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="filterSearch" name="filter_search" placeholder="رقم الطلب، اسم الزبون...">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="filterStatus" class="form-label">حالة الشحنة</label>
                                                <select class="form-select" id="filterStatus" name="filter_status" dir="">
                                                    <option value="">الكل</option>
                                                    <option value="1">تم الانشاء</option>
                                                    <option value="2">وصلت إلى المخزن الخارجي</option>
                                                    <option value="3">وصلت إلى مخزن ليبيا</option>
                                                    <option value="4">جاهز للتسليم</option>
                                                    <option value="5">تم التسليم</option>
                                                    <option value="0">ملغاة</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="filterShipmentMethod" class="form-label">طريقة الشحن</label>
                                                <select class="form-select" id="filterShipmentMethod" name="filter_shipment_method" dir="">
                                                    <option value="">الكل</option>
                                                    <option value="air">شحن جوي</option>
                                                    <option value="sea">شحن بحري</option>
                                                    <option value="express">شحن سريع</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-2">تصفية</button>
                                                <button type="reset" class="btn btn-light">إعادة</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Filter Bar -->

                                    <!-- Orders Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">رقم الطلب</th>
                                                    <th scope="col">اسم الزبون</th>
                                                    <th scope="col">السعر الإجمالي (LYD)</th>
                                                    <th scope="col">طريقة الشحن</th>
                                                    <th scope="col">الحالة</th>
                                                    <th scope="col">آخر تحديث</th>
                                                    <th scope="col">إجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>SHEIN-12345</td>
                                                    <td>محمد علي</td>
                                                    <td>275.00 LYD</td>
                                                    <td>شحن جوي</td>
                                                    <td><span class="badge bg-info text-dark">وصلت إلى المخزن الخارجي</span></td>
                                                    <td>2023-10-25</td>
                                                    <td class="actions-btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-info" title="عرض التفاصيل"><i class="fa fa-eye"></i></button>
                                                        <a type="button" href="update_order.php?id=" class="btn btn-sm btn-warning" title="تعديل"><i class="fa fa-edit"></i></a>
                                                        <button type="button" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>ORD-67890</td>
                                                    <td>فاطمة حسن</td>
                                                    <td>550.25 LYD</td>
                                                    <td>شحن سريع</td>
                                                    <td><span class="badge bg-success">تم التسليم</span></td>
                                                    <td>2023-10-22</td>
                                                    <td class="actions-btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-info" title="عرض التفاصيل"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-sm btn-warning" title="تعديل"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>AMZ-101112</td>
                                                    <td>أحمد خالد</td>
                                                    <td>165.50 LYD</td>
                                                    <td>شحن بحري</td>
                                                    <td><span class="badge bg-primary">تم الانشاء</span></td>
                                                    <td>2023-10-28</td>
                                                    <td class="actions-btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-info" title="عرض التفاصيل"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-sm btn-warning" title="تعديل"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>NMC-131415</td>
                                                    <td>سارة إبراهيم</td>
                                                    <td>302.00 LYD</td>
                                                    <td>شحن جوي</td>
                                                    <td><span class="badge bg-warning text-dark">جاهز للتسليم</span></td>
                                                    <td>2023-10-20</td>
                                                    <td class="actions-btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-info" title="عرض التفاصيل"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-sm btn-warning" title="تعديل"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>XYZ-161718</td>
                                                    <td>عمر عبدالله</td>
                                                    <td>95.75 LYD</td>
                                                    <td>شحن سريع</td>
                                                    <td><span class="badge" style="background-color: #6f42c1; color: white;">وصلت إلى مخزن ليبيا</span></td>
                                                    <td>2023-11-01</td>
                                                    <td class="actions-btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-info" title="عرض التفاصيل"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-sm btn-warning" title="تعديل"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Orders Table -->

                                    <!-- Pagination (Placeholder - Backend implementation needed) -->
                                    <nav aria-label="Page navigation example" class="mt-4">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item disabled"><a class="page-link" href="#">السابق</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">التالي</a></li>
                                        </ul>
                                    </nav>
                                    <!-- End Pagination -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'footer.php'; ?>
                </div>
            </div>
            <?php include 'sidebar.php' ?>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php include 'js.php'; ?>

    <script>
        // Basic script to handle form submission for filtering (preventDefault to show it's client-side for now)
        // In a real app, this form would submit to the server (PHP) to re-query the database.
        const filterForm = document.querySelector('.forms-sample.p-3.border');
        if (filterForm) {
            filterForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent actual form submission
                // Get filter values
                const searchTerm = document.getElementById('filterSearch').value;
                const status = document.getElementById('filterStatus').value;
                const shipmentMethod = document.getElementById('filterShipmentMethod').value;

                console.log('Filtering with:', {
                    searchTerm,
                    status,
                    shipmentMethod
                });
                alert('تتم عملية التصفية الآن (هذه رسالة تجريبية). في التطبيق الفعلي، سيتم تحديث الجدول.');
                // Here you would typically make an AJAX call or reload the page with query parameters
                // For example: window.location.href = `?search=${searchTerm}&status=${status}&method=${shipmentMethod}`;
            });

            filterForm.addEventListener('reset', function(event) {
                console.log('Resetting filters');
                // In a real app, this would also likely reload the page without filter parameters
                // or clear them and make an AJAX call.
                alert('تمت إعادة تعيين الفلاتر (هذه رسالة تجريبية).');
                // window.location.href = window.location.pathname; // To clear query params
            });
        }
    </script>
</body>

</html>