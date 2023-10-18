<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';

// Retrieve field name and data types from the POST request
$field_name = $_POST['fieldName'];
$data_types = json_decode($_POST['dataTypes'], true);

// Ensure proper error handling and validation
// Function to validate field name and data types
function validateField($field_name, $data_types) {
    // Implement your validation logic here
    // Example validation: Ensure $field_name is not empty and $data_types is an array
    if (empty($field_name) || !is_array($data_types)) {
        return false;
    }
    return true;
}

// Perform database insertion for the field and data types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        // Validate input
        if (!validateField($field_name, $data_types)) {
            die("Invalid input data.");
        }

        $response = [
            'field_name' => $field_name,
            'data_types' => $data_types
        ];


        // // Insert field into the database
        // $stmt = $pdo->prepare("INSERT INTO fields (field_name) VALUES (?)");
        // $stmt->execute([$field_name]);
        // $field_id = $pdo->lastInsertId();

        // // Insert data types associated with the field
        // foreach ($data_types as $data_type) {
        //     $type = $data_type['type'];
        //     $type_name = $data_type['name'];

        //     $stmt = $pdo->prepare("INSERT INTO data_types (field_id, type, type_name) VALUES (?, ?, ?)");
        //     $stmt->execute([$field_id, $type, $type_name]);
        // }
        echo json_encode($response);
        // echo json_encode(["message" => "Field added successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

// Return success or error response
$response = ['message' => 'Field added successfully'];
// echo json_encode($response);
?>
