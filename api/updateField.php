<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';
require 'utils.php';

// Retrieve field name, and data types from the POST request
$old_field_name = $_POST['OldfieldName'];
$field_name = $_POST['fieldName'];
$data_types = json_decode($_POST['dataTypes'], true);

// Perform database update for the field and data types
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        // Validate input
        if (!validateField($field_name, $data_types)) {
            die("Invalid input data.");
        }

        // Rename the existing table with a temporary name
        $tempTableName = $old_field_name . '_temp';
        $renameSQL = "RENAME TABLE $old_field_name TO $tempTableName";
        $pdo->exec($renameSQL);

        // Create the new table with the updated structure
        $createTableSQL = "CREATE TABLE $field_name (id INT AUTO_INCREMENT PRIMARY KEY, ";
        
        foreach ($data_types as $data_type) {
            $column_name = $data_type['name'];
            $column_type = getColumnTypeForDataType($data_type['type']);
            $createTableSQL .= "`$column_name` $column_type, ";;
        }
    
        $createTableSQL = rtrim($createTableSQL, ", "); // Remove the trailing comma
        $createTableSQL .= ")";
    
        $pdo->exec($createTableSQL);

        // // Copy data from the temporary table to the new one
        // $copyDataSQL = "INSERT INTO $field_name SELECT * FROM $tempTableName";
        // $pdo->exec($copyDataSQL);

        // Delete the temporary table
        $dropTempTableSQL = "DROP TABLE $tempTableName";
        $pdo->exec($dropTempTableSQL);

        echo json_encode(["message" => "Field updated successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
