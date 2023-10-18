<?php
// Include database connection setup (modify the details as per your configuration)
require 'config.php';
require 'utils.php';

// Format the retrieved data and prepare it for response
$tables = []; // An array to store tables and their columns

// Retrieve tables and their associated columns from the database
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Get all table names in the database
        $stmt = $pdo->query("SHOW TABLES");
        $tableNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $id = 1; // Initialize the id variable

        // Iterate through the table names
        foreach ($tableNames as $tableName) {
            // Get the columns and their data types for each table
            $stmt = $pdo->query("DESCRIBE $tableName");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $table = [
                'name' => $tableName,
                'id' => $id, 
                'columns' => []
            ];

            // Iterate through the columns and skip the 'id' column
            foreach ($columns as $column) {
                if ($column['Field'] !== 'id') {
                    $columnInfo = [
                        'field' => $column['Field'],
                        'type' => getHtmlInputTypeForDataType($column['Type'])
                    ];
                    $table['columns'][] = $columnInfo;
                }
            }

            $tables[] = $table;
            $id++;
        }

        echo json_encode(["tables" => $tables]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
