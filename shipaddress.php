<?php
// --- PHP to fetch data ---
// This is a conceptual block. In a real application,
// you would connect to your database and fetch the addresses.
// $conn = new mysqli("localhost", "username", "password", "database");
// if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
// $sql = "SELECT id, country, shipping_type, location_address, created_at, is_active FROM shipping_address ORDER BY created_at DESC";
// $result = $conn->query($sql);
// $addresses = [];
// if ($result && $result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $addresses[] = $row;
//     }
// }
// $conn->close();

// For demonstration, let's use sample data:
$addresses = [
    [
        'id' => 1,
        'country' => 'ليبيا',
        'shipping_type' => 'بري',
        'location_address' => 'شارع الجمهورية, طرابلس, مستودع رقم 5',
        'created_at' => '2023-10-26 10:00:00',
        'is_active' => 1
    ],
    [
        'id' => 2,
        'country' => 'تركيا',
        'shipping_type' => 'جوي',
        'location_address' => 'Istanbul Logistics Center, Warehouse A-12',
        'created_at' => '2023-10-25 15:30:00',
        'is_active' => 1
    ],
    [
        'id' => 3,
        'country' => 'الصين',
        'shipping_type' => 'بحري',
        'location_address' => 'Shenzhen Port, Bay Area, Section 3, Unit 7B',
        'created_at' => '2023-10-22 09:00:00',
        'is_active' => 0
    ]
];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <?php include 'head.php'; // Assuming head.php contains meta tags, CSS links etc. ?>
    <title>عناوين الشحن</title>
</head>
<body dir="rtl">
<div class="container-scroller">
    <?php include 'navbar.php'; // Assuming navbar.php contains the top navigation bar ?>
    <div class="container-fluid page-body-wrapper">
        <?php include 'sidebar.php'; // Assuming sidebar.php contains the side navigation ?>
        <div class="main-panel">
            <div class="content-wrapper" style="direction: rtl;">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">عناوين الشحن</h4>
                                        <p class="card-description">قائمة بعناوين الشحن المسجلة</p>
                                    </div>
                                    <div>
                                        <a href="create_address.php" class="btn btn-primary btn-icon-text">
                                            <i class="mdi mdi-plus btn-icon-prepend"></i> إضافة عنوان جديد
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الدولة</th>
                                                <th>نوع الشحن</th>
                                                <th>عنوان الموقع</th>
                                                <th>تاريخ الإنشاء</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($addresses)): ?>
                                                <?php foreach ($addresses as $index => $address): ?>
                                                    <tr>
                                                        <td><?php echo $index + 1; ?></td>
                                                        <td><?php echo htmlspecialchars($address['country']); ?></td>
                                                        <td><?php echo htmlspecialchars($address['shipping_type']); ?></td>
                                                        <td><?php echo nl2br(htmlspecialchars($address['location_address'])); ?></td>
                                                        <td><?php echo date('Y-m-d H:i', strtotime($address['created_at'])); ?></td>
                                                        <td>
                                                            <?php if ($address['is_active'] == 1): ?>
                                                                <label class="badge badge-success">فعال</label>
                                                            <?php else: ?>
                                                                <label class="badge badge-danger">غير فعال</label>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="edit_address.php?id=<?php echo $address['id']; ?>" class="btn btn-sm btn-outline-info btn-icon-text">
                                                                <i class="mdi mdi-pencil btn-icon-prepend"></i> تعديل
                                                            </a>
                                                            <!-- Add delete button/form here if needed -->
                                                            <!-- <a href="delete_address.php?id=<?php echo $address['id']; ?>" class="btn btn-sm btn-danger btn-icon-text" onclick="return confirm('هل أنت متأكد من الحذف؟');">
                                                                <i class="mdi mdi-delete btn-icon-prepend"></i> حذف
                                                            </a> -->
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">لا توجد عناوين مسجلة حالياً.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'footer.php'; // Assuming footer.php contains footer content ?>
            </div>
        </div>
    </div>
</div>
<?php include 'js.php'; // Assuming js.php contains JavaScript files ?>
</body>
</html>