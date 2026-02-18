<?php
function getTop10TracksByMood($apiKey, $agentAccessId, $tracks_preferences, $tracks_all,$targetMood='') {
    $apiUrl = "https://agent.timeweb.cloud/api/v1/cloud-ai/agents/{$agentAccessId}/v1/chat/completions";

    if ($targetMood != '') {
        $systemPrompt = 'Analyze mood descriptions of preferencedTracks and choose 10 IDs that best match the required mood in random order: '. $tracks_all .'. The required mood is referenced in "targetMood". Prioritize targetMood above any other moods. DO NOT include the preferencedTracks if they do not fit the targetMood. Respond ONLY in format {"track_ids": [1,2,3,4,5,6,7,8,9,10]}. Use only provided IDs. Return EXACTLY 10 IDs.';

        $userPrompt = json_encode([
        'targetMood'   => $targetMood,
        'preferencedTracks' => $tracks_preferences,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    else {
        $systemPrompt = 'Analyze track titles, genres, artists and mood descriptions and choose 10 IDs that best match the preferencedTracks in random order: '. $tracks_all .'. Prioritize mood above other characteristics. Priority of given characteristics from the most important to least: mood, genre, artist, track title. Respond ONLY in format {"track_ids": [1,2,3,4,5,6,7,8,9,10]}. Use only provided IDs. Return EXACTLY 10 IDs.';

        $userPrompt = json_encode([
        'preferencedTracks' => $tracks_preferences,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    $requestData = [
        'messages' => [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user',   'content' => $userPrompt],
        ],
        'response_format' => [
            'type' => 'text'
        ],
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData, JSON_UNESCAPED_UNICODE));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return ['success' => false, 'error' => 'cURL error: ' . $curlError];
    }

    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['success' => false, 'error' => 'JSON parse error: ' . json_last_error_msg()];
    }

    if (isset($decoded['error'])) {
        return ['success' => false, 'error' => 'API error: ' . json_encode($decoded['error'], JSON_UNESCAPED_UNICODE)];
    }

    $rawText = $decoded['choices'][0]['message']['content'] ?? '';
    preg_match('/\{[^}]*"track_ids"[^}]*\}/', $rawText, $matches);
    if (!empty($matches)) {
        $jsonStr = $matches[0];
        $result = json_decode($jsonStr, true);
        if (isset($result['track_ids']) && is_array($result['track_ids'])) {
            return ['success' => true, 'track_ids' => $result['track_ids']];
        }
    }

    return ['success' => false, 'error' => 'No valid track_ids in response'];
}

// Настройка API
$apiKey = ''; // Вставьте ваш API ключ
$agentAccessId = ''; // Вставьте Access ID
?>