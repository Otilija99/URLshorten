<?php

echo 'Enter the long URL: ';
$longUrl = trim(fgets(STDIN));

$apiUrl = 'https://cleanuri.com/api/v1/shorten';
$postData = [
    'url' => $longUrl
];

$curlName = curl_init($apiUrl);

curl_setopt($curlName, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlName, CURLOPT_POST, true);
curl_setopt($curlName, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($curlName, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($curlName, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curlName);

if (curl_errno($curlName)) {
    echo 'Request Error: ' . curl_error($curlName) . PHP_EOL;
    exit;
}

curl_close($curlName);

$responseData = json_decode($response, true);

if ($responseData !== null && isset($responseData['result_url'])) {
    echo 'Short URL: ' . $responseData['result_url'] . PHP_EOL;
} else {
    echo 'Failed to shorten URL.' . PHP_EOL;
}
