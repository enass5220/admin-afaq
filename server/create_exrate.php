<?php
header('Content-Type: application/json; charset=utf-8'); // Always set content type to JSON
include "connn.php"; // Your database connection file

// Get the posted data.
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true); // true for associative array

// Basic validation (add more as needed)
if (empty($data['name']) || empty($data['code']) || !isset($data['dinar'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$currencyName = trim($data['name']);
$currencyCode = strtoupper(trim($data['code'])); // Often codes are uppercase
$valueVsDinar = filter_var($data['dinar'], FILTER_VALIDATE_FLOAT);
$isActive = isset($data['isactive']) && $data['isactive'] === true ? 1 : 0;


if ($valueVsDinar === false || $valueVsDinar <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid value for "Value vs Dinar".']);
    exit;
}

try {
    $pdo = conopen(); 
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM exchange_rates WHERE curr_short = :currency_code");
    $stmtCheck->bindParam(':currency_code', $currencyCode);
    $stmtCheck->execute();
    if ($stmtCheck->fetchColumn() > 0) {
        http_response_code(409); // Conflict
        echo json_encode(['success' => false, 'message' => 'Currency code already exists.']);
        exit;
    }

    $sql = "INSERT INTO exchange_rates (curr_name, curr_short, rate_to_lyd, is_active)
            VALUES (:currency_name, :currency_code, :value_vs_dinar, :is_active)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':currency_name', $currencyName);
    $stmt->bindParam(':currency_code', $currencyCode);
    $stmt->bindParam(':value_vs_dinar', $valueVsDinar);
    $stmt->bindParam(':is_active', $isActive, PDO::PARAM_INT); // Ensure integer for boolean

    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(['success' => true, 'message' => 'Exchange rate added successfully.', 'id' => $pdo->lastInsertId()]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Failed to add exchange rate.']);
    }

} catch (\PDOException $e) {
    // Log the error in a real application
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>