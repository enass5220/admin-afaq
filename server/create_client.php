<?php
// Set the content type to application/json for the response
header('Content-Type: application/json');
include "connn.php";
try {
    $pdo = conopen();
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'فشل الاتصال بقاعدة البيانات.']);
    error_log('Database connection failed: ' . $e->getMessage()); // Log error for admin
    exit;
}
// --- END DATABASE CONFIGURATION ---

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// --- VALIDATION ---
$errors = [];

// Get data from POST request (form was serialized, so data is in $_POST)
$fullName = isset($_POST['username']) ? trim(htmlspecialchars($_POST['username'])) : '';
$customerCode = isset($_POST['code']) ? trim(htmlspecialchars($_POST['code'])) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim(htmlspecialchars($_POST['phone'])) : '';
$password = isset($_POST['password1']) ? $_POST['password1'] : '';
$password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

// Basic required field checks
if (empty($fullName)) {
    $errors['username'] = 'اسم الزبون كامل مطلوب.';
}
if (empty($customerCode)) {
    $errors['code'] = 'كود الشحن مطلوب.';
}
if (empty($email)) {
    $errors['email'] = 'البريد الإلكتروني مطلوب.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'صيغة البريد الإلكتروني غير صحيحة.';
}
if (empty($phone)) {
    $errors['phone'] = 'رقم الهاتف مطلوب.';
}
// Basic phone number validation (can be more complex)
// Example: Check if it contains only numbers and possibly +, -, ( )
elseif (!preg_match('/^[0-9\s\-\+\(\)]+$/', $phone)) {
    $errors['phone'] = 'رقم الهاتف يحتوي على أحرف غير صالحة.';
}

if (empty($password)) {
    $errors['password'] = 'كلمة المرور مطلوبة.';
} elseif (strlen($password) < 6) { // Example: Minimum password length
    $errors['password'] = 'يجب أن تكون كلمة المرور 6 أحرف على الأقل.';
}
if (empty($password2)) {
    $errors['password2'] = 'تأكيد كلمة المرور مطلوب.';
} elseif ($password !== $password2) {
    $errors['password_match'] = 'كلمتا المرور غير متطابقتين.';
}


// If there are validation errors, return them
if (!empty($errors)) {
    http_response_code(422); // Unprocessable Entity
    echo json_encode([
        'status' => 'error',
        'message' => 'يرجى تصحيح الأخطاء التالية:',
        'errors' => $errors
    ]);
    exit;
}
// --- END VALIDATION ---


// --- PASSWORD HASHING ---
$passwordHash = password_hash($password, PASSWORD_DEFAULT); // Recommended hashing algorithm

try {
    // Check if email or customer_code already exists (optional but good practice)
    $stmtCheck = $pdo->prepare("SELECT id FROM users WHERE email = :email OR customer_code = :customer_code");
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->bindParam(':customer_code', $customerCode);
    $stmtCheck->execute();
    if ($stmtCheck->fetch()) {
        http_response_code(409); // Conflict
        echo json_encode([
            'status' => 'error',
            'message' => 'البريد الإلكتروني أو كود الشحن مسجل مسبقاً.'
        ]);
        exit;
    }


    $sql = "INSERT INTO users (full_name, email, phone_number, password_hash, customer_code, is_confirmed, created_at, updated_at)
            VALUES (:full_name, :email, :phone_number, :password_hash, :customer_code, :is_confirmed, NOW(), NOW())";

    $stmt = $pdo->prepare($sql);

    $isConfirmed = 0; // Or 1 if you want them confirmed by default, or handle via email verification

    $stmt->bindParam(':full_name', $fullName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone_number', $phone);
    $stmt->bindParam(':password_hash', $passwordHash);
    $stmt->bindParam(':customer_code', $customerCode);
    $stmt->bindParam(':is_confirmed', $isConfirmed, PDO::PARAM_INT); // Assuming 0 for false, 1 for true

    if ($stmt->execute()) {
        // $lastInsertId = $pdo->lastInsertId(); // If you need the ID
        echo json_encode([
            'status' => 'success',
            'message' => 'تم تسجيل المستخدم بنجاح!'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'فشل تسجيل المستخدم. خطأ في قاعدة البيانات.'
        ]);
        error_log('User registration failed: ' . implode(" | ", $stmt->errorInfo()));
    }

} catch (\PDOException $e) {
    http_response_code(500);
    $errorMessage = 'حدث خطأ في قاعدة البيانات أثناء تسجيل المستخدم.';
    // SQLSTATE 23000 is integrity constraint violation (e.g., duplicate entry if you have unique constraints)
    if ($e->getCode() == '23000') {
        http_response_code(409); // Conflict
        $errorMessage = 'البريد الإلكتروني أو كود الشحن مسجل مسبقاً.';
    }
    echo json_encode([
        'status' => 'error',
        'message' => $errorMessage
        // 'debug_message' => $e->getMessage() // For development only
    ]);
    error_log('PDOException during registration: ' . $e->getMessage());
}

?>