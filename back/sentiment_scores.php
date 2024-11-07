<?php

function analyze_sentiment($review)
{
    $api_key = 'a63313696e7da5cef9a32432b432437cfcc41213a216bfcb4f2ea420';  // Add your API key here
    $api_url = "https://api.textrazor.com";  // Replace with the appropriate API URL

    $data = http_build_query([
        'text' => $review,
        'extractors' => 'entities,topics,sentiment'
    ]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
                "x-textrazor-key: $api_key\r\n",
            'method'  => 'POST',
            'content' => $data,
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($api_url, false, $context);
    $response = json_decode($result, true);

    // Assuming the API returns a sentiment score between -1 (negative) and 1 (positive)
    $sentiment_score = $response['response']['sentiment']['score'];

    return $sentiment_score;
}

// Example usage:
$review = "This movie was fantastic! Great acting and storyline.";
$score = analyze_sentiment($review);

$review_id = 1; // Assuming this is the review ID
$sentiment_score = analyze_sentiment($review);  // Call the sentiment function
$sentiment_rating = ($sentiment_score > 0.3) ? 5 : (($sentiment_score < -0.3) ? 1 : 3); // Convert score to 1-5 rating

// Store the sentiment score in the database
$query = "UPDATE review_rating SET sentiment_score = $sentiment_rating WHERE id = $review_id";
mysqli_query($conn, $query);

?>