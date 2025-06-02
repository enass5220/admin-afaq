<?php
// Set the content type to application/json
header('Content-Type: application/json');
include "connn.php";
try {
    $pdo = conopen();
} catch (\PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed. Please check server configuration.'
        // 'debug_message' => $e->getMessage() // For development only, remove for production
    ]);
    // Log the detailed error for the admin, don't show to user in production
    error_log('Database connection failed: ' . $e->getMessage());
    exit;
}
// --- END DATABASE CONFIGURATION ---

// Get the JSON data from the request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true); // true for associative array

// Check if JSON decoding was successful
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON input: ' . json_last_error_msg()
    ]);
    exit;
}

// --- VALIDATION ---
$errors = [];

// Validate 'addr' (address ID)
if (empty($data['addr'])) {
    $errors['addr'] = 'Address ID is required.';
} else {
    $addr = trim(htmlspecialchars($data['addr'])); // Basic sanitization
}

// Validate 'munit' (measurement unit)
if (empty($data['munit'])) {
    $errors['munit'] = 'Measurement unit is required.';
} else {
    $munit = trim(htmlspecialchars($data['munit']));

}

// Validate 'price'
if (!isset($data['price']) || !is_numeric($data['price']) || floatval($data['price']) < 0) {
    $errors['price'] = 'Price must be a non-negative number.';
} else {
    $price = floatval($data['price']);
}

// Validate 'curr' (currency)
if (empty($data['curr'])) {
    $errors['curr'] = 'Currency is required.';
} else {
    $curr = trim(strtoupper(htmlspecialchars($data['curr'])));
    if (strlen($curr) !== 3) { // Basic check for 3-letter currency code
        $errors['curr'] = 'Currency code must be 3 characters.';
    }
}

// Validate 'nunit' (numeric unit)
if (!isset($data['nunit']) || !is_numeric($data['nunit']) || floatval($data['nunit']) <= 0) {
    $errors['nunit'] = 'Numeric unit must be a positive number.';
} else {
    $nunit = floatval($data['nunit']);
}

// Validate 'isactive' (boolean)
// JSON true becomes PHP true, JSON false becomes PHP false.
// If it comes as string "true" or "false", filter_var helps.
/* if (!isset($data['isactive'])) {
    $errors['isactive'] = 'Activity status is required.';
} else {
    // filter_var is robust for various boolean representations ("true", "false", 1, 0, true, false)
    $isactive = filter_var($data['isactive'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    if ($isactive === null) {
        $errors['isactive'] = 'Invalid activity status. Must be true or false.';
    }
} */


if (!empty($errors)) {
    http_response_code(422); // Unprocessable Entity (validation errors)
    echo json_encode([
        'status' => 'error',
        'message' => 'Validation failed.',
        'errors' => $errors
    ]);
    exit;
}
// --- END VALIDATION ---


// --- DATABASE INSERTION ---
// Assuming you have a table named 'shipping_prices'
// Adjust column names as per your database schema
// Example table structure at the end of this script

try {
    $sql = "INSERT INTO shipping_prices (shipaddress_id , unit, unit_number, price_per_unit, currency, created_at, effective_date)
            VALUES (:addr, :munit, :nunit, :price, :curr, NOW(), NOW())";

    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':addr', $addr);
    $stmt->bindParam(':munit', $munit);
    $stmt->bindParam(':price', $price); // PDO will handle float type
    $stmt->bindParam(':curr', $curr);
    $stmt->bindParam(':nunit', $nunit); // PDO will handle float type
    //$stmt->bindParam(':isactive', $isactive, PDO::PARAM_BOOL); // Explicitly bind as boolean

    if ($stmt->execute()) {
        $lastInsertId = $pdo->lastInsertId();
        echo json_encode([
            'status' => 'success',
            'message' => 'تمت الإضافة بنجاح.', // "Added successfully."
            'id' => $lastInsertId // Optionally return the ID of the new record
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to create shipping price. Database error.'
        ]);
        // Log detailed error: $stmt->errorInfo()
        error_log('Shipping price insert failed: ' . implode(" | ", $stmt->errorInfo()));
    }

} catch (\PDOException $e) {
    http_response_code(500);
    $errorMessage = 'A database error occurred while creating the shipping price.';
    // Check for specific error codes, e.g., duplicate entry
    if ($e->getCode() == '23000') { // SQLSTATE 23000 is integrity constraint violation
        // This could be a duplicate key error. Adjust message accordingly.
        http_response_code(409); // Conflict
        $errorMessage = 'This shipping price configuration might already exist or violates a constraint.';
    }
    echo json_encode([
        'status' => 'error',
        'message' => $errorMessage
        // 'debug_message' => $e->getMessage() // For development only
    ]);
    error_log('PDOException on insert: ' . $e->getMessage());
}

?>