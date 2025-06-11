<?php
// Set headers for a clean JSON API response
header('Content-Type: application/json; charset=utf-8');

// Include your database connection file
include "connn.php";

// --- 1. Security: Only accept POST requests ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// --- 2. Establish Database Connection ---
try {
    $pdo = conopen();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    // For production, log the error instead of showing it to the user
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// --- 3. Receive and Sanitize Input ---
$order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
$orderno = trim($_POST['orderno'] ?? '');
$trackno = trim($_POST['trackno'] ?? ''); // Optional
$olink = filter_input(INPUT_POST, 'olink', FILTER_VALIDATE_URL);
$total_price_orig = filter_input(INPUT_POST, 'total_price_orig', FILTER_VALIDATE_FLOAT);
$total_cost_lyd = filter_input(INPUT_POST, 'total_price_lyd', FILTER_VALIDATE_FLOAT);
//$currency = $_POST['currency'];
// Important: The exchange_rate value is POSTed, not the ID
$exchange_rate_value = $_POST['exchange_rate_id']; 
$add_id = filter_input(INPUT_POST, 'add_id1', FILTER_VALIDATE_INT);
$ostate = filter_input(INPUT_POST, 'ostate', FILTER_VALIDATE_INT);
$weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
// The ID of the shipping price rule
$weightprice_id = filter_input(INPUT_POST, 'unit', FILTER_VALIDATE_INT);
$weight_price_lyd = filter_input(INPUT_POST, 'total_ship_lyd', FILTER_VALIDATE_FLOAT);
$weight_price_total = filter_input(INPUT_POST, 'total_ship_curr', FILTER_VALIDATE_FLOAT); 

// --- 4. Input Validation ---
$errors = [];
if (empty($order_id)) $errors[] = "Order ID is missing or invalid.";
if (empty($orderno)) $errors[] = "Order Number is required.";
if (empty($olink)) $errors[] = "A valid Order Link is required.";
if ($total_price_orig === false || $total_price_orig <= 0) $errors[] = "Original price must be a positive number.";

if ($exchange_rate_value === false || $exchange_rate_value <= 0) $errors[] = "Exchange rate must be a positive number.";
if (empty($add_id)) $errors[] = "Shipping address is required.";
if (empty($ostate)) $errors[] = "Order status is required.";
if ($weight === false || $weight < 0) $errors[] = "Weight must be a valid number.";
if ($weight_price_lyd === false || $weight_price_lyd < 0) $errors[] = "weight_price_lyd must be a valid number.";
if ($weight_price_total === false || $weight_price_total < 0) $errors[] = "weight_price_total must be a valid number.";
if (empty($weightprice_id)) $errors[] = "weightprice_id rule is required.";


if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Invalid input provided.', 'errors' => $errors]);
    exit;
}

// --- 5. Server-Side Calculation and Database Update (Transaction) ---
try {
    // Begin a transaction
    $pdo->beginTransaction();

   

    // C. Prepare the main UPDATE statement
    $sql = "UPDATE orders SET
                order_number = ?,
                tracking_number = ?,
                shein_link = ?,
                total_cost_usd = ?,
                exchange_rate_id = ?, 
                total_cost_lyd = ?,
                shipadd_id = ?,
                order_status = ?,
                shipping_weight = ?,
                weightprice_id = ?,
                weight_price_total = ?,
                weight_price_lyd = ?
            WHERE id = ?";
    $params = [
        $orderno,
        $trackno,
        $olink,
        $total_price_orig,
        $exchange_rate_value, // Storing the rate value itself
        $total_cost_lyd,
        $add_id,
        $ostate,
        $weight,
        $weightprice_id,
        $weight_price_total,
        $weight_price_lyd,
        $order_id // This is for the WHERE clause
    ];
    
    $stmt_update = $pdo->prepare($sql);
    $stmt_update->execute($params);

    // D. Commit the transaction
    $pdo->commit();

    // --- 6. Send Success Response ---
    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Order updated successfully!']);

} catch (Exception $e) {
    // If anything fails, roll back the transaction
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'status' => 'error', 
        'message' => 'An error occurred during the update process.',
        'details' => $e->getMessage() // For development/debugging
    ]);
}
?>