<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['file'])) {
        die("No se envió ningún archivo.");
    }

    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Error al subir archivo.");
    }

    // Nombre seguro y único
    $newFileName = "file_" . uniqid() . "_" . basename($file["name"]);

    // 🔥 RUTA CORRECTA: carpeta uploads dentro de src
    $destination = "/var/www/php/src/uploads/" . $newFileName;

    // Crear directorio si no existe (útil si faltaba)
    if (!is_dir("/var/www/php/src/uploads")) {
        mkdir("/var/www/php/src/uploads", 0775, true);
    }

    // Mover archivo
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        die("Error al mover archivo.");
    }

    echo "Archivo subido correctamente: " . $newFileName;
}
