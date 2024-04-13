<?php
session_start();
if (isset($_POST['lang'])) {
    $_SESSION['language'] = $_POST['lang']; // Store the chosen language in the session
    echo 'Language updated';
} else {
    echo 'No language provided';
}