<?php
// --- PHP to fetch shipment data and status history ---
// This is a conceptual block.
$shipment_data = null;
$status_history = [];
$error_message = '';
$tracking_id_input = '';

// Define status labels for clarity
$status_labels = [
    "1" => "تم الإنشاء",
    "2" => "وصلت إلى المخزن الخارجي",
    "3" => "وصلت إلى مخزن ليبيا",
    "4" => "جاهزة للتسليم",
    "5" => "تم التسليم",
    "6" => "تم الإلغاء" // Example of another status
];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tracking_id'])) {
    $tracking_id_input = trim($_POST['tracking_id']);
    // --- Database Connection & Query (Example) ---
    // $conn = new mysqli("localhost", "username", "password", "database");
    // if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    //
    // // Try fetching by orderno or trackno
    // $stmt = $conn->prepare("SELECT * FROM shipments WHERE orderno = ? OR trackno = ? LIMIT 1");
    // $stmt->bind_param("ss", $tracking_id_input, $tracking_id_input);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // if ($result->num_rows > 0) {
    //     $shipment_data = $result->fetch_assoc();
    //     // Fetch status history for this shipment_data['id']
    //     // $stmt_history = $conn->prepare("SELECT status_code, status_timestamp, notes FROM shipment_status_history WHERE shipment_id = ? ORDER BY status_timestamp ASC");
    //     // $stmt_history->bind_param("i", $shipment_data['id']);
    //     // $stmt_history->execute();
    //     // $history_result = $stmt_history->get_result();
    //     // while($row = $history_result->fetch_assoc()) { $status_history[] = $row; }
    //     // $stmt_history->close();
    // } else {
    //     $error_message = "لم يتم العثور على شحنة بالرقم المدخل.";
    // }
    // $stmt->close();
    // $conn->close();
    // --- End Example ---

    // For demonstration, let's use sample data if a specific ID is entered:
    if ($tracking_id_input === 'SHEIN12345') {
        $shipment_data = [
            'id' => 1,
            'username' => 'Ali_Baba',
            'orderno' => 'SHEIN12345',
            'trackno' => 'TRACK98765',
            'olink' => 'https://example.com/order/shein12345',
            'total_price_orig' => 150.50,
            'currency_orig' => 'USD', // Assuming currency is stored
            'exchange_rate' => 5.50,
            'total_price_lyd' => 827.75,
            'shipment_method' => 'air',
            'ostate' => '3', // Current status code
            'created_at' => '2023-10-20 10:00:00' // Assuming you have this
        ];
        $status_history = [
            ['status_code' => '1', 'status_timestamp' => '2023-10-20 10:05:00', 'notes' => 'تم إنشاء الطلب من قبل العميل.'],
            ['status_code' => '2', 'status_timestamp' => '2023-10-22 14:30:00', 'notes' => 'تم استلام الشحنة في مستودع الصين.'],
            ['status_code' => '3', 'status_timestamp' => '2023-10-28 09:15:00', 'notes' => 'وصلت الشحنة إلى مستودعنا في ليبيا.'],
        ];
    } elseif ($tracking_id_input === 'ORDERXYZ') {
         $shipment_data = [
            'id' => 2,
            'username' => 'Fatima_Ahmed',
            'orderno' => 'ORDERXYZ',
            'trackno' => null,
            'olink' => 'https://example.com/order/orderxyz',
            'total_price_orig' => 75.00,
            'currency_orig' => 'USD',
            'exchange_rate' => 5.50,
            'total_price_lyd' => 412.50,
            'shipment_method' => 'sea',
            'ostate' => '1',
            'created_at' => '2023-10-27 11:00:00'
        ];
        $status_history = [
            ['status_code' => '1', 'status_timestamp' => '2023-10-27 11:05:00', 'notes' => 'تم إنشاء الطلب.'],
        ];
    }
     else {
        $error_message = "لم يتم العثور على شحنة بالرقم المدخل.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <?php include 'head.php'; ?>
    <title>تتبع الشحنات</title>
    <style>
        .timeline {
            list-style-type: none;
            position: relative;
            padding-left: 1.5rem;
        }
        .timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            right: 29px; /* Adjust for RTL */
            width: 2px;
            height: 100%;
            z-index: 400;
        }
        .timeline > li {
            margin: 20px 0;
            padding-right: 2.5em; /* Adjust for RTL */
            padding-left: 0;
        }
        .timeline > li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            right: 20px; /* Adjust for RTL */
            width: 20px;
            height: 20px;
            z-index: 400;
        }
        .timeline > li.active:before {
            border-color: #28a745; /* Green for active/current status */
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
                    <div class="row">
                        <div class="col-md-10 mx-auto grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center mb-4">تتبع شحنتك</h4>
                                    <p class="card-description text-center">أدخل رقم الطلب أو رقم التتبع الخاص بك لمعرفة حالة شحنتك.</p>

                                    <form class="forms-sample mb-5" method="POST" action="track_shipment.php">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg" name="tracking_id" value="<?php echo htmlspecialchars($tracking_id_input); ?>" placeholder="رقم الطلب أو رقم التتبع" aria-label="رقم الطلب أو رقم التتبع" required>
                                            <button class="btn btn-primary btn-lg" type="submit">بحث <i class="fa fa-search ms-1"></i></button>
                                        </div>
                                    </form>

                                    <?php if ($error_message): ?>
                                        <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                                    <?php endif; ?>

                                    <?php if ($shipment_data): ?>
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">تفاصيل الشحنة: <?php echo htmlspecialchars($shipment_data['orderno']); ?></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>اسم المستخدم:</strong> <?php echo htmlspecialchars($shipment_data['username']); ?></p>
                                                        <p><strong>رقم الطلب:</strong> <?php echo htmlspecialchars($shipment_data['orderno']); ?></p>
                                                        <?php if ($shipment_data['trackno']): ?>
                                                        <p><strong>رقم التتبع:</strong> <?php echo htmlspecialchars($shipment_data['trackno']); ?></p>
                                                        <?php endif; ?>
                                                        <p><strong>تاريخ الإنشاء:</strong> <?php echo date("Y-m-d H:i", strtotime($shipment_data['created_at'])); ?></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>الحالة الحالية:</strong>
                                                            <span class="badge bg-success fs-6">
                                                                <?php echo isset($status_labels[$shipment_data['ostate']]) ? htmlspecialchars($status_labels[$shipment_data['ostate']]) : 'غير معروف'; ?>
                                                            </span>
                                                        </p>
                                                        <p><strong>رابط الطلبية:</strong> <a href="<?php echo htmlspecialchars($shipment_data['olink']); ?>" target="_blank">عرض الطلبية</a></p>
                                                        <p><strong>طريقة الشحن:</strong> <?php echo htmlspecialchars($shipment_data['shipment_method'] == 'air' ? 'جوي' : ($shipment_data['shipment_method'] == 'sea' ? 'بحري' : 'سريع')); ?></p>
                                                    </div>
                                                </div>

                                                <hr>
                                                <h5 class="mt-4 mb-3">سجل تتبع الشحنة:</h5>
                                                <?php if (!empty($status_history)): ?>
                                                    <ul class="timeline">
                                                        <?php foreach (array_reverse($status_history) as $index => $status_item): // Show newest first ?>
                                                            <li class="<?php echo ($index == 0) ? 'active' : ''; // Mark the latest status as active ?>">
                                                                <div class="fw-bold"><?php echo isset($status_labels[$status_item['status_code']]) ? htmlspecialchars($status_labels[$status_item['status_code']]) : 'تحديث حالة'; ?></div>
                                                                <small class="text-muted"><i class="fa fa-clock"></i> <?php echo date("Y-m-d H:i", strtotime($status_item['status_timestamp'])); ?></small>
                                                                <?php if (!empty($status_item['notes'])): ?>
                                                                    <p class="mt-1 mb-0"><?php echo htmlspecialchars($status_item['notes']); ?></p>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <p>لا يوجد سجل تتبع متوفر لهذه الشحنة بعد.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

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