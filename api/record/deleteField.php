<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';

// Retrieve the field ID from the DELETE request
$field_id = $_GET['fieldId'];

// Ensure proper error handling and validation
// Function to validate field ID
function validateFieldId($fieldId) {
    // Implement your validation logic here
    // Example validation: Ensure $fieldId is a positive integer
    return is_numeric($fieldId) && intval($fieldId) > 0;
}

// Perform database deletion for the field
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $field_id = $_DELETE['field_id'];

    // Validate input (field ID)
    if (!validateFieldId($field_id)) {
        die("Invalid field ID.");
    }

    try {
        // Delete the field and its associated data types
        $stmt = $pdo->prepare("DELETE fields, data_types
                             FROM fields
                             LEFT JOIN data_types ON fields.id = data_types.field_id
                             WHERE fields.id = ?");
        $stmt->execute([$field_id]);

        echo json_encode(["message" => "Field deleted successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

// Return success or error response
$response = ['message' => 'Field deleted successfully'];
echo json_encode($response);
?>