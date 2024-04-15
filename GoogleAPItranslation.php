<?php
// Function to translate text using Google Translate API
function translateText($text, $targetLanguage) {
    $apiKey = 'AIzaSyCvYhmuQVyP-O-9tflpHafAVYrehO29oAc';
    $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=' . $targetLanguage;

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);                 
    $responseDecoded = json_decode($response, true);
    curl_close($handle);

    return $responseDecoded['data']['translations'][0]['translatedText'];
}

// Check if the language toggle is triggered
if(isset($_GET['lang']) && $_GET['lang'] == 'ms') {
    // Translate the content
    $translatedText = translateText($_GET['content'], 'ms');
    echo $translatedText;
} else {
    // Display original content
    echo $_GET['content'];
}
?>
