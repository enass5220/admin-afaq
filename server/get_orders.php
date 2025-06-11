<?php
// Set headers for a clean JSON API response
header('Content-Type: application/json; charset=utf-8');

// The file containing your PDO connection function
include "connn.php"; 

try {
    $pdo = conopen();
    // Set PDO to throw exceptions on error. This is crucial for robust error handling.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    // For production, log the error instead of showing details to the user
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// --- Parameter Handling ---
// Use trim() to handle searches with just spaces. Default to an empty string.
$searchTerm = trim($_GET['term'] ?? ''); 
$id = trim($_GET['id'] ?? 0); 
// Get status. Use filter_var to ensure it's a valid integer. Default to 0 ("all").
$status = filter_var($_GET['stat'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['default' => 0]]);

// Get page number. Ensure it's a positive integer. Default to 1.
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);

// --- Database Query ---
try {
    if(isset($_GET['id'])){
        $sq = 'select o.order_code, o.order_number, o.tracking_number, o.order_status, o.shein_link, ex.curr_short,
o.shipadd_id, sa.country, sa.shipping_type as typ, u.full_name, o.shipping_weight, o.total_cost_usd, o.exchange_rate_id, o.total_cost_lyd,
o.receipt_id, o.weight_price_lyd, o.weight_price_total, o.weightprice_id from orders o 
inner join users u on o.user_id=u.id
inner join exchange_rates ex on ex.id=o.exchange_rate_id
inner join shipping_address sa on sa.id=o.shipadd_id
left join shipping_prices sp on sp.id=o.weightprice_id
where o.id=?';
$params = [$_GET['id']];
    }else{
        $sq = 'CALL sp_GetOrders(?, ?, ?)';
        $params=[$searchTerm, $status, $page];
    }
    // The procedure has 3 parameters: term, status, page number
    $stmt = $pdo->prepare($sq);

    // Execute with the sanitized parameters
    $stmt->execute($params);

    // 1. Fetch the first result set: the list of orders
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. CRITICAL FIX: Move to the next result set to access the count
    $stmt->nextRowset();

    // 3. Fetch the second result set: the total records count
    $countRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $countRow ? (int)$countRow['total_records'] : 0;
    
    // Close the cursor before sending the response
    $stmt->closeCursor();

    // --- Format the Final JSON Response ---
    // This structure is much more useful for a front-end
    $response = [
        'status' => 'success',
        'pagination' => [
            'page' => $page,
            'total_records' => $totalRecords,
            'total_pages' => ceil($totalRecords / 10) // Assuming 10 items per page
        ],
        'data' => $orders
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    // For production, log this error. For development, the message is helpful.
    echo json_encode(['status' => 'error', 'message' => 'Query failed.', 'details' => $e->getMessage()]);
    exit;
}
?>