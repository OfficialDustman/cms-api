<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';

// Format the retrieved data and prepare it for response
$fields = []; // An array to store fields and their data types

// Retrieve fields and their associated data types from the database
// Ensure proper error handling and query execution
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT fields.id, fields.field_name, GROUP_CONCAT(data_types.type_name ORDER BY data_types.id ASC) AS data_types
                             FROM fields
                             LEFT JOIN data_types ON fields.id = data_types.field_id
                             GROUP BY fields.id");

        $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["fields" => $fields]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

// Loop through the retrieved records and populate $fields array
while ($row = /* fetch data types from the database */) {
    $field = [
        'id' => $row['field_id'],
        'name' => $row['field_name'],
        'dataTypes' => [] // An array to store data types for this field
    ];

    // Retrieve associated data types for this field from the database

    // Loop through the retrieved data types and add them to the field's 'dataTypes' array
    while ($data_type_row = /* fetch data types from the database */) {
        $data_type = [
            'type' => $data_type_row['data_type'],
            'name' => $data_type_row['data_type_name']
        ];
        $field['dataTypes'][] = $data_type;
    }

    $fields[] = $field;
}

// Return the formatted data as JSON response
echo json_encode($fields);
?>
