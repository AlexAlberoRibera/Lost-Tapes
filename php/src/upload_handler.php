<?php

require_once __DIR__ . "/../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['file'])) {
        die("No se envió ningún archivo.");
    }

    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Error al subir archivo.");
    }

    // ============================
    // Guardar archivo subido
    // ============================
    $newFileName = "file_" . uniqid() . "_" . basename($file["name"]);
    $uploadDir = __DIR__ . "/uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $destination = $uploadDir . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die("Error al mover archivo. Verifica permisos en uploads/");
    }

    // ============================
    // Leer Excel o CSV
    // ============================
    $ext = pathinfo($destination, PATHINFO_EXTENSION);

    try {
        if (in_array(strtolower($ext), ['csv'])) {
            $reader = IOFactory::createReader('Csv');
            $reader->setDelimiter(',');
            $spreadsheet = $reader->load($destination);
        } else {
            $spreadsheet = IOFactory::load($destination);
        }
    } catch (Exception $e) {
        die("Error leyendo archivo: " . $e->getMessage());
    }

    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    if (count($data) < 2) {
        die("El archivo no contiene datos suficientes.");
    }

    // ============================
    // Normalizar encabezados
    // ============================
    $headers = array_map('trim', $data[0]);
    if (substr($headers[0], 0, 3) === "\xEF\xBB\xBF") {
        $headers[0] = substr($headers[0], 3); // quitar BOM
    }

    $headersLower = array_map('strtolower', $headers);
    $requiredColumns = ["id", "nombre", "descripcion", "duracion", "carpeta"];

    foreach ($requiredColumns as $col) {
        if (!in_array(strtolower($col), $headersLower)) {
            die("ERROR: Falta columna requerida → " . $col);
        }
    }

    $colIndex = array_flip($headersLower);

    // ============================
    // Procesar datos
    // ============================
    $peliculas = [];
    foreach ($data as $i => $row) {
        if ($i === 0) continue; // encabezado
        if (empty(array_filter($row))) continue; // ignorar filas vacías

        $item = [];
        foreach ($requiredColumns as $col) {
            $val = trim($row[$colIndex[strtolower($col)]]);
            $item[strtolower($col)] = $val;
        }

        $peliculas[] = $item;
    }

    // ============================
    // Guardar JSON en public/data/
    // ============================
    $jsonDir = __DIR__ . "/public/data/";
    if (!is_dir($jsonDir)) {
        mkdir($jsonDir, 0775, true);
    }

    $jsonPath = $jsonDir . "peliculas.json";

    if (file_put_contents($jsonPath, json_encode(['peliculas' => $peliculas], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
        die("Error al guardar el JSON. Verifica permisos en public/data/");
    }

    echo "Archivo procesado correctamente. JSON generado en public/data/peliculas.json";
}
