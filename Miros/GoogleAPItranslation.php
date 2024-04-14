<?php
require 'vendor/autoload.php';

use Google\Cloud\Translate\V2\TranslateClient;

// Set up Google Cloud Translation API credentials
$projectId = 'learned-maker-420119';
$apiKey = 'AIzaSyCvYhmuQVyP-O-9tflpHafAVYrehO29oAc';

// Create a TranslateClient object
$translate = new TranslateClient([
    'projectId' => $projectId,
    'key' => $apiKey
]);

var_dump(file_exists('vendor/autoload.php')); // Check if autoload file exists
var_dump(class_exists('Google\Cloud\Translate\V2\TranslateClient')); // Check if TranslateClient class is recognized


// Function to translate text
function translateText($text, $targetLanguage) {
    global $translate;
    $result = $translate->translate($text, ['target' => $targetLanguage]);
    return $result['text'];
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Language Toggle</title>
</head>
<body>

<!-- Language Toggle Links -->
<a href="?lang=en">English</a> | <a href="?lang=ms">Malaysian</a>

<!-- Display Text Based on Language -->
<h1><?php echo translateText('Welcome', 'en'); ?></h1>
<p><?php echo translateText('Hello, how are you?', 'ms'); ?></p>

</body>
</html>

<?php
// Language toggle logic
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if ($lang == 'en' || $lang == 'ms') {
        // You can store the selected language in session or cookie for persistence
        // For simplicity, I'm just appending it to the URL
        $redirectUrl = $_SERVER['PHP_SELF'] . '?lang=' . $lang;
        header('Location: ' . $redirectUrl);
        exit;
    }
}
?>