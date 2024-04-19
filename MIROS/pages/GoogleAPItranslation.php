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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/nav_bar.css">

 <button onclick="translateToMalay()">Translate to Malay</button>

    <script>
        function translateToMalay() {
            // Get the current page content
            var content = document.body.innerHTML;

            // Send a request to translate.php with the content and language parameter
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'GoogleAPITranslation.php?content=' + encodeURIComponent(content) + '&lang=ms', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Replace the current page content with the translated content
                    document.open();
                    document.write(xhr.responseText);
                    document.close();
                }
            };
            xhr.send();
        }
    </script> 
