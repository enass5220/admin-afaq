<?php
// Set the content type to application/json
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // For development, allow all origins. Restrict in production.
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Handle preflight request for CORS
    http_response_code(200);
    exit;
}

// Get the JSON data sent from Angular
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

// Basic validation (add more robust validation)
if (empty($input['username']) || empty($input['orderno']) || empty($input['olink']) || !isset($input['total_price_orig']) || !isset($input['exchange_rate']) || empty($input['shipment_method'])) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'success' => false,
        'message' => 'بيانات غير مكتملة. يرجى ملء جميع الحقول المطلوبة.'
    ]);
    exit;
}

// --- Database Connection (Example using PDO) ---
$host = 'localhost';
$db   = 'logistics';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Prepare data for insertion
    $username = $input['username'];
    $orderno = $input['orderno'];
    $trackno = isset($input['trackno']) ? $input['trackno'] : null;
    $olink = $input['olink'];
    $total_price_orig = (float) $input['total_price_orig'];
    $currency_orig = isset($input['currency_orig']) ? $input['currency_orig'] : 'USD';
    $exchange_rate = (float) $input['exchange_rate'];
    $total_price_lyd = (float) $input['total_price_lyd']; // Should be recalculated server-side for security
    $shipment_method = $input['shipment_method'];
    $ostate = isset($input['ostate']) ? $input['ostate'] : '1'; // Default state
    $payment_status = isset($input['payment_status']) ? $input['payment_status'] : 'pending';

    // Server-side recalculation of final price for integrity
    if ($total_price_orig && $exchange_rate) {
        $calculated_total_price_lyd = round($total_price_orig * $exchange_rate, 2);
        // You might want to compare $calculated_total_price_lyd with $input['total_price_lyd']
        // and log discrepancies, but generally trust the server-side calculation.
        $total_price_lyd = $calculated_total_price_lyd;
    }


    // SQL to insert data (adjust table and column names)
    $sql = "INSERT INTO shipments (username, orderno, trackno, olink, total_price_orig, currency_orig, exchange_rate, total_price_lyd, shipment_method, ostate, payment_status, created_at) 
            VALUES (:username, :orderno, :trackno, :olink, :total_price_orig, :currency_orig, :exchange_rate, :total_price_lyd, :shipment_method, :ostate, :payment_status, NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':username' => $username,
        ':orderno' => $orderno,
        ':trackno' => $trackno,
        ':olink' => $olink,
        ':total_price_orig' => $total_price_orig,
        ':currency_orig' => $currency_orig,
        ':exchange_rate' => $exchange_rate,
        ':total_price_lyd' => $total_price_lyd,
        ':shipment_method' => $shipment_method,
        ':ostate' => $ostate,
        ':payment_status' => $payment_status
    ]);

    $shipmentId = $pdo->lastInsertId();

    http_response_code(201); // Created
    echo json_encode([
        'success' => true,
        'message' => 'تم إنشاء طلب الشحن بنجاح!',
        'shipmentId' => $shipmentId
    ]);

} catch (\PDOException $e) {
    http_response_code(500); // Internal Server Error
    // Log the error: error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'حدث خطأ في الخادم أثناء معالجة الطلب: ' . $e->getMessage() // Be cautious about exposing detailed errors in production
    ]);
}
?>