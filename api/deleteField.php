<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';

// Retrieve the field NAME from the DELETE request
$field_name = $_GET['fieldName'];

// Perform database deletion for the field
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $deleteTableSQL = "DROP TABLE $field_name";

        $pdo->exec($deleteTableSQL);

        echo json_encode(["message" => "Field deleted successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
