<?php

function getHtmlInputTypeForDataType($data_type) {
    if (strpos($data_type, 'int') !== false || strpos($data_type, 'decimal') !== false || strpos($data_type, 'float') !== false) {
        return 'number';
    } elseif (strpos($data_type, 'date') !== false) {
        return 'date';
    } elseif (strpos($data_type, 'text') !== false || strpos($data_type, 'varchar') !== false) {
        return 'text';
    } elseif (strpos($data_type, 'blob') !== false) {
        return 'file';
    } else {
        return 'text'; // Default to text input type if the data type is not recognized
    }
}

function getColumnTypeForDataType($data_type) {
    switch ($data_type) {
        case 'text':
            return 'VARCHAR(255)'; // Example: Text data type maps to VARCHAR
        case 'number':
            return 'INT'; // Example: Number data type maps to INT
        case 'date':
            return 'DATE'; // Example: Date data type maps to DATE
        case 'image':
            return 'BLOB'; // Example: Image data type maps to BLOB (binary large object)
        case 'file':
            return 'LONGBLOB'; // Example: File data type maps to BLOB
        default:
            return 'VARCHAR(255)'; // Default to VARCHAR if the data type is not recognized
    }
}

// Function to validate field ID
function validateFieldId($fieldId) {
    return is_numeric($fieldId) && intval($fieldId) > 0;
}


// Function to validate field name and data types
function validateField($field_name, $data_types) {
    if (empty($field_name) || !is_array($data_types)) {
        return false;
    }
    return true;
}

?>

