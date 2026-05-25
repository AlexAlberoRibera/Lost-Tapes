<?php

header('Content-Type: application/json');

$json = file_get_contents(__DIR__ . '/public/data/peliculas.json');

echo $json;