<?php
include(__DIR__ . "/config.php");

function askAI($prompt){

    $url = "https://openrouter.ai/api/v1/chat/completions";

    $data = [
        "model" => "openai/gpt-oss-120b:free",
        "messages" => [
            [
                "role" => "user",
                "content" => $prompt
            ]
        ],
        "temperature" => 0.7,
        "max_tokens" => 1200 // 🔥 reduced (important)
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\n" .
                         "Authorization: Bearer " . OPENROUTER_API_KEY . "\r\n" .
                         "HTTP-Referer: https://mcaprephub.xo.je\r\n" .
                         "X-Title: MCAPrepHub\r\n",
            "method"  => "POST",
            "content" => json_encode($data),
            "timeout" => 60
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if($response === FALSE){
        return "API_ERROR";
    }

    $result = json_decode($response, true);

    if(!$result || isset($result['error'])){
        return "API_ERROR";
    }

    return $result['choices'][0]['message']['content'] ?? "";
}
?>