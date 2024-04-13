<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Google\Cloud\Translate\V2\TranslateClient;

$translate = new TranslateClient([
    'key' => 'AIzaSyCYdUIsAFu7AeawgYjlSjHkTFviuD7U554'
]);

$text = 'Test, world!';
$targetLanguage = 'ms'; // Malay

$translation = $translate->translate($text, [
    'target' => $targetLanguage
]);

echo $translation['text'];
?>
