<?php
// debug (only while testing)
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/error_log.txt');

// CORS + JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

// handle preflight and exit early (so browser gets proper CORS response)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// load env: prefer real env vars (Render), fallback to local .env file
$env = [];
$env['DB_HOST'] = getenv('DB_HOST') ?: null;
$env['DB_USER'] = getenv('DB_USER') ?: null;
$env['DB_PASS'] = getenv('DB_PASS') ?: null;
$env['DB_NAME'] = getenv('DB_NAME') ?: null;

if (!$env['DB_HOST'] || !$env['DB_USER'] || !$env['DB_NAME']) {
    $ini = @parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_TYPED);
    if ($ini !== false) {
        $env = array_merge($env, array_intersect_key($ini, ['DB_HOST'=>0,'DB_USER'=>0,'DB_PASS'=>0,'DB_NAME'=>0]));
    }
}

// final sanity: make sure required keys exist (DB_PASS may be empty)
if (empty($env['DB_HOST']) || empty($env['DB_USER']) || empty($env['DB_NAME'])) {
    http_response_code(500);
    echo json_encode(['status' => 0, 'error' => 'Database credentials not configured']);
    exit();
}

// connect
$con = @mysqli_connect($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME']);

if (!$con) {
    http_response_code(500);
    // log detailed error server-side, show safe message to client
    error_log("DB connect error: " . mysqli_connect_error());
    echo json_encode(['status' => 0, 'error' => 'Database connection failed']);
    exit();
}

// ready. other files can include index.php and use $con.
// NOTE: do NOT read php://input here — let included endpoints read it themselves.
?>
