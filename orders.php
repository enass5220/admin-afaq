<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الشحنات | جميع الطلبات</title>
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .actions-btn-group .btn {
            margin-right: 5px;
        }

        .actions-btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Make pagination links clickable */
        .pagination .page-link {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php' ?>
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
                                    <!-- Filter Bar - Added an ID for easy access -->
                                    <form id="filterForm" class="forms-sample p-3 border rounded shadow-sm mb-4 bg-light">
                                        <div class="row align-items-end">
                                            <div class="col-md-5 mb-3">
                                                <label for="filterSearch" class="form-label">بحث</label>
                                                <input type="text" class="form-control" id="filterSearch" placeholder="رقم الطلب، اسم الزبون...">
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label for="filterStatus" class="form-label">حالة الشحنة</label>
                                                <select dir="ltr" class="form-select" id="filterStatus">
                                                    <option value="0">الكل</option> <!-- Value 0 for "All" -->
                                                    <option value="1">تم الانشاء</option>
                                                    <option value="2">وصلت إلى المخزن الخارجي</option>
                                                    <option value="3">وصلت إلى مخزن ليبيا</option>
                                                    <option value="4">جاهز للتسليم</option>
                                                    <option value="5">تم التسليم</option>
                                                    <option value="6">ملغاة</option> <!-- Assuming 6 is cancelled -->
                                                </select>
                                            </div>
                                            <!-- Removed shipment method filter as it's not in the SP -->
                                            <div class="col-md-2 mb-3 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-2">تصفية</button>
                                                <button type="reset" class="btn btn-light">إعادة</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Filter Bar -->

                                    <!-- Orders Table - The body will be populated by JavaScript -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">رقم الطلب</th>
                                                    <th scope="col">اسم الزبون</th>
                                                    <th scope="col">السعر الإجمالي (د.ل.)</th>
                                                    <th scope="col">طريقة الشحن</th>
                                                    <th scope="col">الحالة</th>
                                                    <th scope="col">آخر تحديث</th>
                                                    <th scope="col">إجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ordersTableBody">
                                                <!-- Dynamic content will be injected here -->
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Orders Table -->

                                    <!-- Pagination will be generated by JavaScript -->
                                    <nav aria-label="Page navigation" class="mt-4">
                                        <ul id="pagination" class="pagination justify-content-center">
                                            <!-- Pagination links will be injected here -->
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
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php include 'js.php'; ?>

    <script>
        $(document).ready(function() {
            function fetchOrders(page = 1) {
                const searchTerm = $('#filterSearch').val();
                const status = $('#filterStatus').val();
                const tableBody = $('#ordersTableBody');

                // Show a loading spinner
                tableBody.html(`<tr><td colspan="8" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`);

                $.ajax({
                    url: 'server/get_orders.php',
                    type: 'GET',
                    data: {
                        term: searchTerm,
                        stat: status,
                        page: page
                    },
                    dataType: 'json',
                    success: function(response) {
                        tableBody.empty(); // Clear loading spinner or old data

                        if (response.status === 'success' && response.data.length > 0) {
                            // Populate the table with new data
                            $.each(response.data, function(index, order) {
                                const rowNum = (response.pagination.page - 1) * 10 + index + 1;
                                const statusBadge = getStatusBadge(order.status);
                                const row = `
                                    <tr>
                                        <th scope="row">${rowNum}</th>
                                        <td>${order.code}</td>
                                        <td>${order.full_name}</td>
                                        <td>${parseFloat(order.total).toFixed(2)}</td>
                                        <td>${order.satype}</td>
                                        <td>${statusBadge}</td>
                                        <td>${order.date}</td>
                                        <td class="actions-btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-info" title="عرض التفاصيل"><i class="fa fa-eye"></i></button>
                                            <a href="update_order.php?id=${order.id}" class="btn btn-sm btn-outline-warning" title="تعديل"><i class="fa fa-edit"></i></a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="حذف" onclick="deleteOrder(${order.id})"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `;
                                tableBody.append(row);
                            });
                        } else {
                            // Show a "no results" message
                            tableBody.html('<tr><td colspan="8" class="text-center">لا توجد نتائج مطابقة.</td></tr>');
                        }

                        // Render the pagination controls
                        renderPagination(response.pagination);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        tableBody.html('<tr><td colspan="8" class="text-center text-danger">حدث خطأ أثناء تحميل البيانات.</td></tr>');
                        console.error('AJAX Error:', textStatus, errorThrown, jqXHR.responseText);
                    }
                });
            }

            // --- Helper Function to Create Status Badges ---
            function getStatusBadge(status) {
                const statuses = {
                    1: { text: 'تم الانشاء', class: 'bg-primary' },
                    2: { text: 'وصلت إلى المخزن الخارجي', class: 'bg-info text-dark' },
                    3: { text: 'وصلت إلى مخزن ليبيا', class: 'badge', style: 'background-color: #6f42c1; color: white;' },
                    4: { text: 'جاهز للتسليم', class: 'bg-warning text-dark' },
                    5: { text: 'تم التسليم', class: 'bg-success' },
                    6: { text: 'ملغاة', class: 'bg-danger' }
                };
                const statusInfo = statuses[status] || { text: 'غير معروف', class: 'bg-secondary' };
                // Handle the custom style for status 3
                const styleAttr = statusInfo.style ? `style="${statusInfo.style}"` : '';
                return `<span class="badge ${statusInfo.class}" ${styleAttr}>${statusInfo.text}</span>`;
            }

            // --- Function to Render Pagination Controls ---
            function renderPagination(pagination) {
                const paginationUl = $('#pagination');
                paginationUl.empty();

                if (pagination.total_pages <= 1) return; // No need for pagination if there's only one page

                // Previous button
                let prevDisabled = pagination.page <= 1 ? "disabled" : "";
                paginationUl.append(`<li class="page-item ${prevDisabled}"><a class="page-link" href="#" data-page="${pagination.page - 1}">السابق</a></li>`);

                // Page number links
                for (let i = 1; i <= pagination.total_pages; i++) {
                    let activeClass = i === pagination.page ? "active" : "";
                    paginationUl.append(`<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`);
                }

                // Next button
                let nextDisabled = pagination.page >= pagination.total_pages ? "disabled" : "";
                paginationUl.append(`<li class="page-item ${nextDisabled}"><a class="page-link" href="#" data-page="${pagination.page + 1}">التالي</a></li>`);
            }


            // --- Event Handlers ---

            // Handle filter form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                fetchOrders(1); // Always go to page 1 when applying new filters
            });

            // Handle filter form reset
            $('#filterForm').on('reset', function() {
                // Use a short timeout to allow the form fields to clear before fetching
                setTimeout(() => fetchOrders(1), 0);
            });
            
            // Handle clicks on pagination links (using event delegation)
            $('#pagination').on('click', '.page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) { // Check if the link is not disabled
                    fetchOrders(page);
                }
            });

            // Initial load of data
            fetchOrders(1);
        });

        // Placeholder for a delete function
        function deleteOrder(orderId) {
            if (confirm(`هل أنت متأكد من رغبتك في حذف الطلب رقم ${orderId}؟`)) {
                // Here you would make an AJAX call to a delete_order.php script
                console.log('Deleting order ' + orderId);
                alert('تم الحذف (هذه رسالة تجريبية).');
                // On success, you would reload the table:
                // fetchOrders($('#pagination .active .page-link').data('page') || 1);
            }
        }
    </script>
</body>
</html>