<?php

function get_route_distance($destination) {
    // Define the API endpoint and parameters
    $authorizationToken = $_ENV['RADAR_KEY'];
    $url = "https://api.radar.io/v1/route/distance";
    $params = [
        'origin' => '41.197640785083046, -73.88853982328246',
        'destination' => $destination,
        'modes' => 'foot,car,bike',
        'units' => 'imperial'
    ];

    // Build the full URL with query parameters
    $queryString = http_build_query($params);
    $fullUrl = $url . '?' . $queryString;

    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => $fullUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: $authorizationToken"
        ],
    ]);

    // Execute the request and capture the response
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        echo 'cURL error: ' . curl_error($curl);
        curl_close($curl);
        return null;
    }

    // Close the cURL session
    curl_close($curl);

    // Return the response
    return $response;
}