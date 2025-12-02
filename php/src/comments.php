<?php
// Simple comments API backed by a JSON file for demo (productId 1 = Harakiri)
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/includes/json_connect.php';
session_start();

$dataFile = __DIR__ . '/public/data/comments.json';

// ensure file exists
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

function readComments() {
    global $dataFile;
    $raw = @file_get_contents($dataFile);
    $arr = json_decode($raw, true);
    return is_array($arr) ? $arr : [];
}

function writeComments(array $arr) {
    global $dataFile;
    $tmp = $dataFile . '.tmp';
    file_put_contents($tmp, json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    rename($tmp, $dataFile);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $productId = isset($_GET['productId']) ? (int)$_GET['productId'] : null;
    $all = readComments();
    if ($productId !== null) {
        $filtered = array_values(array_filter($all, function($c) use($productId){ return isset($c['productId']) && (int)$c['productId'] === $productId; }));
        echo json_encode($filtered);
        exit;
    }
    echo json_encode($all);
    exit;
}

if ($method === 'POST') {
    // require JSON body
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);
    if (!is_array($json)) {
        http_response_code(400);
        echo json_encode(['error' => 'invalid_json']);
        exit;
    }

    // require authentication
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'not_authenticated']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    // try to fetch username via json-server users endpoint
    $user = read_user($userId);
    if ($user === false) {
        $userName = 'Usuario';
    } else {
        $userName = is_array($user) && isset($user[0]) ? ($user[0]['nom_usuari'] ?? $user[0]['nom'] ?? 'Usuario') : ($user['nom_usuari'] ?? $user['nom'] ?? 'Usuario');
    }

    $content = trim($json['content'] ?? '');
    $rating = isset($json['rating']) ? (int)$json['rating'] : null;
    $productId = isset($json['productId']) ? (int)$json['productId'] : null;

    if ($productId === null || $content === '') {
        http_response_code(422);
        echo json_encode(['error' => 'missing_fields']);
        exit;
    }

    $all = readComments();
    $new = [
        'id' => uniqid('c'),
        'productId' => $productId,
        'userId' => $userId,
        'userName' => $userName,
        'content' => $content,
        'rating' => $rating,
        'likes' => 0,
        'created_at' => date('c')
    ];

    $all[] = $new;
    writeComments($all);

    http_response_code(201);
    echo json_encode($new);
    exit;
}

// other methods not implemented
http_response_code(405);
echo json_encode(['error' => 'method_not_allowed']);
