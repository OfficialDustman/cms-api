<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';
require 'utils.php';

// Retrieve field name and data types from the POST request
$field_name = $_POST['fieldName'];
$data_types = json_decode($_POST['dataTypes'], true);

// Perform database table creation and column definition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        if (!validateField($field_name, $data_types)) {
            die("Invalid input data.");
        }

        // Create the table using the field name and data types
        $createTableSQL = "CREATE TABLE $field_name (id INT AUTO_INCREMENT PRIMARY KEY, ";
            
        foreach ($data_types as $data_type) {
            $column_name = $data_type['name'];
            $column_type = getColumnTypeForDataType($data_type['type']); // Use the function to get the correct column type
        
            $createTableSQL .= "`$column_name` $column_type, "; // Wrap column names with backticks
        
        }
        
        $createTableSQL = rtrim($createTableSQL, ", "); // Remove the trailing comma
        $createTableSQL .= ")";
        
        // Execute the SQL to create the table
        $pdo->exec($createTableSQL);

        echo json_encode(["message" => "Table created successfully"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
