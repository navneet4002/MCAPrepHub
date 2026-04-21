<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include(__DIR__ . "/config.php");

// 🔥 OpenRouter Models API
$url = "https://openrouter.ai/api/v1/models";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer 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",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo "Curl Error: " . curl_error($ch);
}

echo "<pre>";
print_r(json_decode($response, true));
?>