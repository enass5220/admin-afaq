<?php
header('Content-Type: application/json; charset=utf-8');
include "connn.php"; // Your database connection file

// Get the posted data from the Angular app
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true); // true for associative array

// --- Basic Validation ---
$errors = [];
if (empty($data['country'])) {
    $errors['country'] = 'الدولة مطلوبة.';
}
if (empty($data['type']) || !in_array($data['type'], [1, 2, 3])) { // Assuming 1, 2, 3 are valid values
    $errors['shipping_type'] = 'نوع الشحن غير صالح.';
}
if (empty($data['address'])) {
    $errors['location_address'] = 'عنوان الموقع التفصيلي مطلوب.';
}
// 'isactive' is a boolean from Angular, it will be true/false or not set if checkbox is weirdly handled
// We'll default to true if present, and handle its conversion to 1/0 later.

if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'يرجى تصحيح الأخطاء التالية:', 'errors' => $errors]);
    exit;
}

// --- Sanitize and Prepare Data ---
$country = trim($data['country']);
$shippingType = (int)$data['type']; // Ensure it's an integer
$locationAddress = trim($data['address']);
$isActive = (isset($data['isactive']) && $data['isactive'] === true) ? 1 : 0;



try {
    $pdo = conopen();
    $sql = "INSERT INTO shipping_address (country, shipping_type, location_address, is_active, created_at)
            VALUES (:country, :shipping_type_id, :location_address, :is_active, NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':shipping_type_id', $shippingType, PDO::PARAM_INT);
    $stmt->bindParam(':location_address', $locationAddress);
    $stmt->bindParam(':is_active', $isActive, PDO::PARAM_INT);

    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode([
            'success' => true,
            'message' => 'تم إضافة عنوان الشحن بنجاح.',
            'id' => $pdo->lastInsertId() // Send back the ID of the newly created address
        ]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'فشل في إضافة عنوان الشحن.']);
    }

} catch (\PDOException $e) {
    // Log the error in a real application
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'خطأ في قاعدة البيانات.', 'details' => $e->getMessage()]);
} catch (\Exception $e) {
    error_log("General Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'حدث خطأ غير متوقع.', 'details' => $e->getMessage()]);
}
?>