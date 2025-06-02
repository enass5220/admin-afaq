<?php
// It's good practice to ensure your JSON output is UTF-8, especially with Arabic text
header('Content-Type: application/json; charset=utf-8');
include "connn.php";

try {
    $pdo = conopen();
    // It's a good idea to set error mode to exception if not already done in conopen()
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    http_response_code(500);
    // For development, $e->getMessage() is useful, for production, a generic message
    echo json_encode(['error' => 'Database connection failed.', 'details' => $e->getMessage()]);
    exit;
}

$searchTerm = isset($_GET['term']) ? trim($_GET['term']) : '';
$users = [];

if (!empty($searchTerm)) {
    try {
        // Use AS for aliases for better readability/standard SQL
        $sql = 'SELECT id, country, shipping_type as "type", location_address as "address"
    , is_active as "active" FROM shipping_address
                WHERE country LIKE :searchTermPhone
                   OR location_address LIKE concat("%",:searchTermCode,"%")
                  
                ORDER BY country ASC
                LIMIT 20';

        $stmt = $pdo->prepare($sql);
        $searchPattern = '%' . $searchTerm . '%';

        // Bind each placeholder
        $stmt->bindValue(':searchTermPhone', $searchPattern, PDO::PARAM_STR);
        $stmt->bindValue(':searchTermCode', $searchPattern, PDO::PARAM_STR);

        $stmt->execute();
        // It's good to specify the fetch mode
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed.', 'details' => $e->getMessage()]);
        exit;
    }
}

echo json_encode($users);
?>