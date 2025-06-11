<?php
header('Content-Type: application/json; charset=utf-8');
include "connn.php"; // Your database connection file

$output = []; // Can be a single object or an array of objects

try {
    $pdo = conopen();
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Good practice

    $sql = "SELECT id, country, shipping_type 'type', location_address 'address', is_active 'active', created_at as created FROM shipping_address";

    // Check if an 'id' GET parameter is set and is a valid number
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
        $id = (int)$_GET['id'];
        $sql .= " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $row['active'] = (bool)$row['active'];
            $output = $row; // Output a single object
        } else {
            // ID was provided but not found
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Exchange rate not found for the given ID.']);
            exit;
        }
    } else {
        // No valid ID provided, fetch all records
        $sql .= " ORDER BY country ASC"; // Or your preferred default order
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rates = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['active'] = (bool)$row['active'];
            $rates[] = $row;
        }
        $output = $rates; // Output an array of objects
    }

} catch (\PDOException $e) {
    http_response_code(500);
    // Log error
    echo json_encode(['error' => 'Database query failed.', 'details' => $e->getMessage()]);
    exit;
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred.', 'details' => $e->getMessage()]);
    exit;
}

// If output is empty (e.g., no ID provided and table is empty, or ID found but was the only record)
// we still want to return a valid JSON structure (empty array or the single object).
// The 404 for specific ID not found is handled above.
if (empty($output) && !(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))) {
    return [];
}

echo json_encode($output);
?>