<?php
// Start session if not already started (useful for user auth, flash messages)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- DATABASE CONNECTION ---
// Option 1: Include your existing connection file
//require_once 'db_connection.php'; // Make sure this file exists and creates a $pdo or $mysqli object

// Option 2: Define connection here (less recommended for multiple files)
/*
$host = 'localhost';
$db   = 'your_database_name';
$user = 'your_db_user';
$pass = 'your_db_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // In a real app, log this error and show a generic message
     error_log("Database Connection Error: " . $e->getMessage());
     die("حدث خطأ في الاتصال بقاعدة البيانات. الرجاء المحاولة لاحقاً.");
}
*/
// --- END DATABASE CONNECTION ---


$clients = [];
$error_message = '';
/* 
try {
    // Your SQL query (avoid selecting password_hash unless absolutely necessary for some backend logic,
    // and never display it on the frontend)
    $stmt = $pdo->query("SELECT `id`, `full_name`, `email`, `phone_number`, `is_confirmed`, `confirmation_date`, `customer_code`, `created_at`, `updated_at` FROM `users` ORDER BY `created_at` DESC");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log("Error fetching clients: " . $e->getMessage()); // Log the detailed error
    $error_message = "حدث خطأ أثناء جلب بيانات الزبائن. الرجاء المحاولة مرة أخرى.";
    // For development, you might want to see the error:
    // $error_message = "Error: " . $e->getMessage();
}
 */
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الزبائن | قائمة الزبائن</title>
    <style>
        /* Optional: Custom styles for the table or specific columns */
        .table th, .table td {
            vertical-align: middle;
        }
        .actions-column a {
            margin-right: 5px;
        }
    </style>
</head>

<body dir="rtl">
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">

                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title">جميع الزبائن</h4>
                                            <p class="card-description">
                                        عرض لجميع الزبائن المسجلين في النظام.
                                                <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                                                    <span class="text-success">تم إضافة الزبون بنجاح!</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div>
                                            <a href="create_client.php" class="btn btn-primary btn-icon-text">
                                                <i class="mdi mdi-plus btn-icon-prepend"></i>زبون جديد 
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> الاسم الكامل </th>
                                                    <th> البريد الالكتروني </th>
                                                    <th> رقم الهاتف </th>
                                                    <th> كود الزبون </th>
                                                    <th> الحالة </th>
                                                    <th> تاريخ التأكيد </th>
                                                    <th> تاريخ الإنشاء </th>
                                                    <th> إجراءات </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($clients) > 0): ?>
                                                    <?php foreach ($clients as $index => $client): ?>
                                                        <tr>
                                                            <td><?php echo $index + 1; // Or $client['id'] if you prefer ?></td>
                                                            <td><?php echo htmlspecialchars($client['full_name']); ?></td>
                                                            <td><?php echo htmlspecialchars($client['email']); ?></td>
                                                            <td><?php echo htmlspecialchars($client['phone_number'] ?? '-'); // Handle null phone number ?></td>
                                                            <td><?php echo htmlspecialchars($client['customer_code'] ?? '-'); ?></td>
                                                            <td>
                                                                <?php if ($client['is_confirmed']): ?>
                                                                    <span class="badge badge-success">مؤكد</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-warning">غير مؤكد</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if (!empty($client['confirmation_date'])) {
                                                                    try {
                                                                        $confDate = new DateTime($client['confirmation_date']);
                                                                        echo $confDate->format('Y-m-d H:i');
                                                                    } catch (Exception $e) {
                                                                        echo htmlspecialchars($client['confirmation_date']); // Fallback
                                                                    }
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                try {
                                                                    $createdDate = new DateTime($client['created_at']);
                                                                    echo $createdDate->format('Y-m-d H:i');
                                                                } catch (Exception $e) {
                                                                    echo htmlspecialchars($client['created_at']); // Fallback
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="actions-column">
                                                                <a href="view_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-gradient-info" title="عرض"><i class="mdi mdi-eye"></i></a>
                                                                <a href="edit_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-gradient-warning" title="تعديل"><i class="mdi mdi-pencil"></i></a>
                                                                <a href="delete_client.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-gradient-danger" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا الزبون؟');"><i class="mdi mdi-delete"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">لا يوجد زبائن لعرضهم حالياً.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
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
</body>
</html>