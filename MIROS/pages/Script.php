<button onclick="translateToMalay()">Translate to Malay</button>
<button onclick="translateToEnglish()">Translate to English</button>

<script>
    function translateToMalay() {
    var content = document.body.innerHTML;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'GoogleAPITranslation.php?content=' + encodeURIComponent(content) + '&lang=ms', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.body.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}


    function translateToEnglish() {
        window.location.reload(); 
    }

    
</script>

