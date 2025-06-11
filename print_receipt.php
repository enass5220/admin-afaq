<?php
// --- PHP to fetch shipment and payment data ---
$shipment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$shipment_data = null;
$payment_data = null; // To store payment status, amount paid, etc.
$error_message = '';

// Define status labels
$status_labels_receipt = [
    "1" => "تم الإنشاء",
    "2" => "وصلت إلى المخزن الخارجي",
    "3" => "وصلت إلى مخزن ليبيا",
    "4" => "جاهزة للتسليم",
    "5" => "تم التسليم",
];

// Define payment status labels
$payment_status_labels = [
    'paid' => 'مدفوعة بالكامل',
    'unpaid' => 'غير مدفوعة',
    'partial' => 'مدفوعة جزئياً',
    'pending' => 'في انتظار الدفع'
];


if ($shipment_id > 0) {
    // --- Database Connection & Query (Example) ---
    // $conn = new mysqli("localhost", "username", "password", "database");
    // if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    //
    // // Fetch shipment details
    // $stmt = $conn->prepare("SELECT s.*, u.full_name as user_full_name FROM shipments s LEFT JOIN users u ON s.user_id = u.id WHERE s.id = ?"); // Assuming a users table
    // $stmt->bind_param("i", $shipment_id);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // if ($result->num_rows > 0) {
    //     $shipment_data = $result->fetch_assoc();
    //
    //     // Fetch payment details for this shipment
    //     // $stmt_payment = $conn->prepare("SELECT payment_status, amount_paid, payment_date, payment_method FROM payments WHERE shipment_id = ? ORDER BY payment_date DESC LIMIT 1");
    //     // $stmt_payment->bind_param("i", $shipment_id);
    //     // $stmt_payment->execute();
    //     // $payment_result = $stmt_payment->get_result();
    //     // if($payment_result->num_rows > 0) {
    //     //     $payment_data = $payment_result->fetch_assoc();
    //     // } else {
    //          // Default payment status if no record found
    //          $payment_data = ['payment_status' => 'unpaid', 'amount_paid' => 0];
    //     // }
    //     // $stmt_payment->close();
    // } else {
    //     $error_message = "لم يتم العثور على شحنة بالمعرف المحدد.";
    // }
    // $stmt->close();
    // $conn->close();
    // --- End Example ---

    // For demonstration, let's use sample data:
    if ($shipment_id === 1) {
        $shipment_data = [
            'id' => 1,
            'username' => 'Ali_Baba', // From the form
            'user_full_name' => 'علي بابا الكامل', // Assumed from a users table
            'orderno' => 'SHEIN12345',
            'trackno' => 'TRACK98765',
            'olink' => 'https://example.com/order/shein12345',
            'total_price_orig' => 150.50,
            'currency_orig' => 'USD',
            'exchange_rate' => 5.50,
            'total_price_lyd' => 827.75,
            'shipment_method' => 'air',
            'ostate' => '3',
            'created_at' => '2023-10-20 10:00:00',
            'shipping_cost_lyd' => 25.00, // Assumed shipping cost added later
            'notes_for_customer' => 'يرجى إحضار الهوية عند الاستلام.'
        ];
        $payment_data = [
            'payment_status' => 'paid', // 'paid', 'unpaid', 'partial'
            'amount_paid_lyd' => 852.75, // total_price_lyd + shipping_cost_lyd
            'payment_date' => '2023-10-29 11:00:00',
            'payment_method' => 'كاش عند الاستلام'
        ];
    } elseif ($shipment_id === 2) {
        $shipment_data = [
            'id' => 2,
            'username' => 'Fatima_Ahmed',
            'user_full_name' => 'فاطمة أحمد المحمد',
            'orderno' => 'ORDERXYZ',
            'trackno' => null,
            'olink' => 'https://example.com/order/orderxyz',
            'total_price_orig' => 75.00,
            'currency_orig' => 'USD',
            'exchange_rate' => 5.50,
            'total_price_lyd' => 412.50,
            'shipment_method' => 'sea',
            'ostate' => '1',
            'created_at' => '2023-10-27 11:00:00',
            'shipping_cost_lyd' => 15.00,
            'notes_for_customer' => null
        ];
        $payment_data = [
            'payment_status' => 'unpaid',
            'amount_paid_lyd' => 0,
            'payment_date' => null,
            'payment_method' => null
        ];
    } else {
        $error_message = "لم يتم العثور على شحنة بالمعرف المحدد.";
    }
} else {
    $error_message = "معرف الشحنة غير صالح.";
}

// Calculate Grand Total
$grand_total_lyd = 0;
if ($shipment_data) {
    $grand_total_lyd = $shipment_data['total_price_lyd'] + ($shipment_data['shipping_cost_lyd'] ?? 0);
}

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <?php include 'head.php'; // Keep common head elements if needed for styling ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة طلبية رقم: <?php echo $shipment_data ? htmlspecialchars($shipment_data['orderno']) : ''; ?></title>
    <!-- Bootstrap CSS (You might load this from head.php or directly) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Tahoma', 'Arial', sans-serif; /* Common font for Arabic receipts */
            background-color: #fff; /* White background for printing */
            direction: rtl;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            width: 80mm; /* Standard thermal receipt width, adjust if A4 */
            /* width: 210mm; For A4 Portrait */
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
        }
        .receipt-header img {
            max-width: 100px; /* Adjust logo size */
            margin-bottom: 10px;
        }
        .receipt-header h4 {
            margin: 5px 0;
            font-size: 1.2em;
        }
        .receipt-details p, .item-details p, .payment-details p {
            margin-bottom: 3px;
            font-size: 0.9em; /* Smaller font for thermal printers */
        }
        .receipt-details strong, .item-details strong, .payment-details strong {
            display: inline-block;
            min-width: 100px; /* Adjust for alignment */
        }
        hr.dotted {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .text-center { text-align: center; }
        .mt-3 { margin-top: 1rem; }
        .mb-3 { margin-bottom: 1rem; }
        .fw-bold { font-weight: bold; }

        .payment-status {
            font-size: 1.1em;
            padding: 8px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .payment-status.paid { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .payment-status.unpaid { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .payment-status.partial { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .payment-status.pending { background-color: #cce5ff; color: #004085; border: 1px solid #b8daff;}


        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #fff; /* Ensure white background for printing */
            }
            .receipt-container {
                width: 100%; /* Or fixed width like 80mm */
                margin: 0 auto;
                padding: 5mm; /* Adjust padding for print */
                border: none;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="no-print text-center my-3">
            <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i> طباعة الفاتورة</button>
            <a href="javascript:history.back()" class="btn btn-secondary">رجوع</a>
        </div>

        <?php if ($error_message): ?>
            <div class="alert alert-danger text-center receipt-container"><?php echo $error_message; ?></div>
        <?php elseif ($shipment_data): ?>
            <div class="receipt-container">
                <div class="receipt-header">
                    <!-- <img src="path/to/your/logo.png" alt="شعار الشركة"> -->
                    <h4>اسم شركتك للشحن</h4>
                    <p>تفاصيل الاتصال الخاصة بك</p>
                    <p>فاتورة طلبية</p>
                </div>
                <hr class="dotted">
                <div class="receipt-details">
                    <p><strong>رقم الفاتورة:</strong> SHIP-<?php echo htmlspecialchars($shipment_data['id']); ?></p>
                    <p><strong>تاريخ الفاتورة:</strong> <?php echo date("Y-m-d H:i"); ?></p>
                    <p><strong>رقم الطلب:</strong> <?php echo htmlspecialchars($shipment_data['orderno']); ?></p>
                    <p><strong>تاريخ الطلب:</strong> <?php echo date("Y-m-d", strtotime($shipment_data['created_at'])); ?></p>
                    <p><strong>اسم العميل:</strong> <?php echo htmlspecialchars($shipment_data['user_full_name'] ?? $shipment_data['username']); ?></p>
                </div>
                <hr class="dotted">
                <h5 class="text-center">تفاصيل الطلبية</h5>
                <div class="item-details">
                    <p><strong>رابط الطلبية:</strong> <a href="<?php echo htmlspecialchars($shipment_data['olink']); ?>" target="_blank">عرض السلعة</a></p>
                    <p><strong>السعر الأصلي:</strong> <?php echo number_format($shipment_data['total_price_orig'], 2); ?> <?php echo htmlspecialchars($shipment_data['currency_orig']); ?></p>
                    <p><strong>سعر الصرف:</strong> <?php echo number_format($shipment_data['exchange_rate'], 2); ?> د.ل./<?php echo htmlspecialchars($shipment_data['currency_orig']); ?></p>
                    <p><strong>السعر بالدينار:</strong> <?php echo number_format($shipment_data['total_price_lyd'], 2); ?> د.ل.</p>
                    <p><strong>تكلفة الشحن:</strong> <?php echo number_format($shipment_data['shipping_cost_lyd'] ?? 0, 2); ?> د.ل.</p>
                    <hr class="dotted">
                    <p class="fw-bold"><strong>الإجمالي المستحق:</strong> <?php echo number_format($grand_total_lyd, 2); ?> د.ل.</p>
                </div>
                <hr class="dotted">
                <div class="payment-details">
                    <h5 class="text-center">حالة الدفع</h5>
                    <?php if ($payment_data): ?>
                        <div class="payment-status <?php echo htmlspecialchars($payment_data['payment_status']); ?>">
                            <?php echo isset($payment_status_labels[$payment_data['payment_status']]) ? htmlspecialchars($payment_status_labels[$payment_data['payment_status']]) : 'غير محدد'; ?>
                        </div>
                        <?php if ($payment_data['payment_status'] === 'paid' || $payment_data['payment_status'] === 'partial'): ?>
                            <p><strong>المبلغ المدفوع:</strong> <?php echo number_format($payment_data['amount_paid_lyd'], 2); ?> د.ل.</p>
                            <?php if($payment_data['payment_date']): ?>
                            <p><strong>تاريخ الدفع:</strong> <?php echo date("Y-m-d H:i", strtotime($payment_data['payment_date'])); ?></p>
                            <?php endif; ?>
                            <?php if($payment_data['payment_method']): ?>
                            <p><strong>طريقة الدفع:</strong> <?php echo htmlspecialchars($payment_data['payment_method']); ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($payment_data['payment_status'] === 'partial' && $grand_total_lyd > $payment_data['amount_paid_lyd']): ?>
                            <p class="fw-bold"><strong>المبلغ المتبقي:</strong> <?php echo number_format($grand_total_lyd - $payment_data['amount_paid_lyd'], 2); ?> د.ل.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-center">لا توجد معلومات دفع مسجلة.</p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($shipment_data['notes_for_customer'])): ?>
                <hr class="dotted">
                <div class="notes">
                    <p><strong>ملاحظات:</strong> <?php echo nl2br(htmlspecialchars($shipment_data['notes_for_customer'])); ?></p>
                </div>
                <?php endif; ?>

                <hr class="dotted">
                <p class="text-center mt-3">شكراً لتعاملكم معنا!</p>
                <p class="text-center"><small>هذه الفاتورة تم إنشاؤها بواسطة النظام.</small></p>
            </div>
        <?php endif; ?>
    </div>


    <?php  include 'js.php'; // Only if it doesn't interfere with print view ?>
</body>
</html>