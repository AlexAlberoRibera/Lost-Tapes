<?php


// Base URL for json-server. Can be overridden via env var or defining constant before include.
if (!defined('JSON_SERVER_BASE')) {
    $env = getenv('JSON_SERVER_BASE');
    define('JSON_SERVER_BASE', $env !== false ? $env : 'http://localhost:3000');
}

function validar_contrasenya(string $contrasenya, string $contrasenya_confirm, ?int $min_len = 6, ?int $max_len = 12): array {
    $errores = [];
    $len = mb_strlen($contrasenya);
    if ($len < $min_len) $errores[] = "La contraseña debe tener al menos {$min_len} caracteres.";
    if ($len > $max_len) $errores[] = "La contraseña no puede tener más de {$max_len} caracteres.";
    if (!preg_match('/[a-z]/', $contrasenya)) $errores[] = "La contraseña debe contener al menos una letra minúscula.";
    if (!preg_match('/[A-Z]/', $contrasenya)) $errores[] = "La contraseña debe contener al menos una letra mayúscula.";
    if (!preg_match('/[0-9]/', $contrasenya)) $errores[] = "La contraseña debe contener al menos un número.";
    if ($contrasenya !== $contrasenya_confirm) $errores[] = "La confirmación de la contraseña no coincide.";
    return $errores;
}

function json_request(string $method, string $path, ?array $data = null, int $timeout = 5) {
    $base = rtrim(JSON_SERVER_BASE, '/');
    $url = $base . '/' . ltrim($path, '/');

    $ch = curl_init();
    $method = strtoupper($method);
    $headers = ['Accept: application/json'];

    if ($data !== null) {
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE);
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $resp = curl_exec($ch);
    if ($resp === false) {
        // minimal logging for the developer
        $err = curl_error($ch);
        curl_close($ch);
        error_log('json_request curl error: ' . $err . ' url: ' . $url);

        // If base host is localhost, try a couple of likely alternatives used when PHP runs inside Docker
        $parsed = parse_url($url);
        if (!empty($parsed['host']) && in_array($parsed['host'], ['localhost', '127.0.0.1'])) {
            $alts = ['host.docker.internal', '172.17.0.1'];
            foreach ($alts as $alt) {
                $altUrl = str_replace($parsed['host'], $alt, $url);
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $altUrl);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
                if ($data !== null) curl_setopt($ch2, CURLOPT_POSTFIELDS, $payload);
                $resp2 = curl_exec($ch2);
                if ($resp2 !== false) {
                    $httpCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                    curl_close($ch2);
                    if ($httpCode2 >= 200 && $httpCode2 < 300) {
                        error_log('json_request: succeeded via fallback host ' . $alt . ' for path ' . $path);
                        $decoded2 = json_decode($resp2, true);
                        if (json_last_error() === JSON_ERROR_NONE) return $decoded2;
                    }
                } else {
                    error_log('json_request fallback to ' . $alt . ' failed: ' . curl_error($ch2));
                    curl_close($ch2);
                }
            }
        }

        return false;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode < 200 || $httpCode >= 300) {
        error_log('json_request http error: ' . $httpCode . ' url: ' . $url . ' resp: ' . $resp);
        return false;
    }

    $decoded = json_decode($resp, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('json_request json decode error: ' . json_last_error_msg() . ' url: ' . $url);
        return false;
    }

    return $decoded;
}

function json_get(string $path) { return json_request('GET', $path, null); }
function json_post(string $path, array $data) { return json_request('POST', $path, $data); }
function json_patch(string $path, array $data) { return json_request('PATCH', $path, $data); }

function read_user($id = null, array $filters = []) {
    if ($id !== null) return json_get('/users/' . urlencode((string)$id));
    $qs = '';
    if (!empty($filters)) {
        $parts = [];
        foreach ($filters as $k => $v) $parts[] = urlencode($k) . '=' . urlencode((string)$v);
        $qs = '?' . implode('&', $parts);
    }
    return json_get('/users' . $qs);
}

function write_user(array $user) {
    return json_post('/users', $user);
}

// Note: kept small and focused. If older code relied on json_connect_get/post
// we can reintroduce compatibility wrappers, but currently they are unused.
