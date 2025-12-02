<?php
// Simple ratings/likes API backed by JSON file. Supports GET summary and POST to toggle like or submit a rating.
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/includes/json_connect.php';
session_start();

$dataFile = __DIR__ . '/public/data/ratings.json';

if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

function readRatings() {
    global $dataFile;
    $raw = @file_get_contents($dataFile);
    $arr = json_decode($raw, true);
    return is_array($arr) ? $arr : [];
}

function writeRatings(array $arr) {
    global $dataFile;
    $tmp = $dataFile . '.tmp';
    file_put_contents($tmp, json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    rename($tmp, $dataFile);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $productId = isset($_GET['productId']) ? (int)$_GET['productId'] : null;
    $all = readRatings();
    if ($productId === null) {
        echo json_encode($all);
        exit;
    }

    $filtered = array_values(array_filter($all, function($r) use($productId){ return isset($r['productId']) && (int)$r['productId'] === $productId; }));
    $likes = 0; $ratingSum = 0; $ratingCount = 0; $userLiked = false; $userRated = null;
    $userId = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    foreach ($filtered as $r) {
        if (!empty($r['like'])) $likes++;
        if (isset($r['rating']) && $r['rating'] !== null) { $ratingSum += (int)$r['rating']; $ratingCount++; }
        if ($userId !== null && isset($r['userId']) && (string)$r['userId'] === (string)$userId) {
            if (!empty($r['like'])) $userLiked = true;
            if (isset($r['rating'])) $userRated = $r['rating'];
        }
    }
    $average = $ratingCount ? ($ratingSum / $ratingCount) : null;
    echo json_encode(['likes' => $likes, 'liked' => $userLiked, 'average' => $average, 'rating_count' => $ratingCount, 'your_rating' => $userRated]);
    exit;
}

if ($method === 'POST') {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);
    if (!is_array($json)) {
        http_response_code(400);
        echo json_encode(['error' => 'invalid_json']);
        exit;
    }

    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'not_authenticated']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $productId = isset($json['productId']) ? (int)$json['productId'] : null;
    if ($productId === null) {
        http_response_code(422);
        echo json_encode(['error' => 'missing_productId']);
        exit;
    }

    $action = isset($json['action']) ? $json['action'] : 'toggle_like';
    $ratingVal = isset($json['rating']) ? (int)$json['rating'] : null;

    $all = readRatings();
    // find existing entry for this user/product
    $foundIndex = null;
    foreach ($all as $i => $r) {
        if (isset($r['productId']) && (int)$r['productId'] === $productId && isset($r['userId']) && (string)$r['userId'] === (string)$userId) { $foundIndex = $i; break; }
    }

    if ($action === 'toggle_like') {
        if ($foundIndex === null) {
            $entry = ['id' => uniqid('r'), 'productId' => $productId, 'userId' => $userId, 'like' => true, 'rating' => null, 'created_at' => date('c')];
            $all[] = $entry;
        } else {
            $all[$foundIndex]['like'] = empty($all[$foundIndex]['like']) ? true : false;
            $all[$foundIndex]['created_at'] = date('c');
        }
    } elseif ($action === 'rate') {
        if ($ratingVal < 1 || $ratingVal > 5) {
            http_response_code(422);
            echo json_encode(['error' => 'invalid_rating']);
            exit;
        }
        if ($foundIndex === null) {
            $entry = ['id' => uniqid('r'), 'productId' => $productId, 'userId' => $userId, 'like' => false, 'rating' => $ratingVal, 'created_at' => date('c')];
            $all[] = $entry;
        } else {
            $all[$foundIndex]['rating'] = $ratingVal;
            $all[$foundIndex]['created_at'] = date('c');
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'unknown_action']);
        exit;
    }

    writeRatings($all);

    // return updated summary for the product
    $filtered = array_values(array_filter($all, function($r) use($productId){ return isset($r['productId']) && (int)$r['productId'] === $productId; }));
    $likes = 0; $ratingSum = 0; $ratingCount = 0; $userLiked = false; $userRated = null;
    foreach ($filtered as $r) {
        if (!empty($r['like'])) $likes++;
        if (isset($r['rating']) && $r['rating'] !== null) { $ratingSum += (int)$r['rating']; $ratingCount++; }
        if (isset($r['userId']) && (string)$r['userId'] === (string)$userId) {
            if (!empty($r['like'])) $userLiked = true;
            if (isset($r['rating'])) $userRated = $r['rating'];
        }
    }
    $average = $ratingCount ? ($ratingSum / $ratingCount) : null;
    http_response_code(201);
    echo json_encode(['likes' => $likes, 'liked' => $userLiked, 'average' => $average, 'rating_count' => $ratingCount, 'your_rating' => $userRated]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'method_not_allowed']);
