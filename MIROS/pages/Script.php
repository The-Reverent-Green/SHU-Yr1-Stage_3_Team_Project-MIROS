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