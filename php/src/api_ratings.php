<?php

header('Content-Type: application/json');

$json = file_get_contents(__DIR__ . '/public/data/ratings.json');

echo $json;