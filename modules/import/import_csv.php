<?php

require_once "../../config/database.php";

/*
|--------------------------------------------------------------------------
| Detect Field Type
|--------------------------------------------------------------------------
*/

function detectFieldType($value)
{
    $value = trim($value);

    if ($value === "") {
        return "text";
    }

    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return "email";
    }

    if (preg_match('/^[0-9]{10,15}$/', $value)) {
        return "phone";
    }

    if (is_numeric($value)) {
        return "number";
    }

    if (strtotime($value) !== false) {
        return "date";
    }

    return "text";
}

/*
|--------------------------------------------------------------------------
| Create Dataset
|--------------------------------------------------------------------------
*/

function createDataset($conn, $name, $userId)
{
    $stmt = $conn->prepare("
        INSERT INTO datasets
        (name, description, icon, color, created_by)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $name,
        "Imported from CSV",
        "bi-file-earmark-spreadsheet",
        "primary",
        $userId
    ]);

    return $conn->lastInsertId();
}

/*
|--------------------------------------------------------------------------
| Create Fields
|--------------------------------------------------------------------------
*/

function createFields($conn, $datasetId, $headers, $sampleRow)
{
    $fieldIds = [];

    foreach ($headers as $index => $header) {

        $type = "text";

        if (isset($sampleRow[$index])) {
            $type = detectFieldType($sampleRow[$index]);
        }

        $stmt = $conn->prepare("
            INSERT INTO dataset_fields
            (dataset_id, field_name, field_type, is_required, field_order)
            VALUES (?, ?, ?, 0, ?)
        ");

        $stmt->execute([
            $datasetId,
            trim($header),
            $type,
            $index + 1
        ]);

        $fieldIds[] = $conn->lastInsertId();
    }

    return $fieldIds;
}

function createRecord($conn, $datasetId, $userId)
{
    $stmt = $conn->prepare("
        INSERT INTO records
        (dataset_id, created_by)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $datasetId,
        $userId
    ]);

    return $conn->lastInsertId();
}
function saveRecordValues($conn, $recordId, $fieldIds, $row)
{
    $stmt = $conn->prepare("
        INSERT INTO record_values
        (record_id, field_id, value)
        VALUES (?, ?, ?)
    ");

    foreach ($fieldIds as $index => $fieldId) {

        $value = $row[$index] ?? "";

        $stmt->execute([
            $recordId,
            $fieldId,
            $value
        ]);
    }
}