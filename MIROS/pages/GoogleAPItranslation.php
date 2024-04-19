
<?php
// Function to translate text using Google Translate API
function translateText($text, $targetLanguage) {
    if ($targetLanguage == 'en') {
        return $text; // Return the original text if the target language is English
    }
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
if(isset($_GET['lang']) && $_GET['content']) {
    $translatedText = translateText($_GET['content'], $_GET['lang']);
    echo $translatedText;
} else {
    // Fallback or error handling
    echo "No content provided.";
}
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
<link rel="stylesheet" href="../css/bootstrap.css">

<button onclick="translateToMalay()">Translate to Malay</button>
<button onclick="window.location.reload();">Translate to English</button>

<script>
    function translateToMalay() {
        var content = document.body.innerText; 

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'GoogleAPITranslation.php?content=' + encodeURIComponent(content) + '&lang=ms', true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                document.body.innerText = xhr.responseText;
            } else {
                console.error('Error translating content');
            }
        };
        xhr.send();
    }
</script>

</script> 
