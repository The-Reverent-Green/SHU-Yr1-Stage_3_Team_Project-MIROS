<?php require("GoogleAPItranslation.php")?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transformers Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h1 {
            color: #333;
        }
        p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Transformers: More Than Meets the Eye</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#overview">Overview</a></li>
            <li><a href="#history">History</a></li>
            <li><a href="#characters">Characters</a></li>
            <li><a href="#media">Media</a></li>
            <li><a href="#merchandise">Merchandise</a></li>
        </ul>
    </nav>
    <main>
        <?php
            $sections = array(
                array(
                    "id" => "overview",
                    "title" => "Overview",
                    "content" => "<p>Transformers is a media franchise produced by American toy company Hasbro and Japanese toy company Takara Tomy. The franchise focuses on sentient robots that can transform into vehicles, animals, and other objects.</p>
                                  <p>Since its inception in the 1980s, Transformers has expanded into various forms of media, including animated television series, comic books, films, video games, and toys.</p>"
                ),
                array(
                    "id" => "history",
                    "title" => "History",
                    "content" => "<p>The Transformers franchise was created by Hasbro in partnership with Takara Tomy. It debuted with a toy line in 1984, which was accompanied by an animated television series produced by Sunbow Productions and Marvel Productions.</p>
                                  <p>Over the years, the franchise has undergone numerous reboots and adaptations, captivating generations of fans with its compelling storytelling and memorable characters.</p>"
                ),
                array(
                    "id" => "characters",
                    "title" => "Characters",
                    "content" => "<p>Some of the iconic characters in the Transformers universe include Optimus Prime, Bumblebee, Megatron, Starscream, and many others. These characters are divided into factions, such as the Autobots and the Decepticons, each with its own agenda and motivations.</p>
                                  <p>Throughout the various iterations of the franchise, new characters are introduced while classic ones are reimagined, keeping the fanbase engaged and excited.</p>"
                ),
                array(
                    "id" => "media",
                    "title" => "Media",
                    "content" => "<p>Transformers has been adapted into multiple forms of media, including animated television series, comic books, films, and video games. The franchise has a rich lore and mythology, explored in depth across different mediums.</p>
                                  <p>Notable adaptations include the original animated series, the live-action film series directed by Michael Bay, and various comic book series published by IDW Publishing.</p>"
                ),
                array(
                    "id" => "merchandise",
                    "title" => "Merchandise",
                    "content" => "<p>Transformers merchandise encompasses a wide range of products, including action figures, clothing, accessories, video games, and collectibles. The franchise's popularity has led to a thriving market for merchandise catering to fans of all ages.</p>
                                  <p>Collectors often seek rare and limited-edition items to add to their collections, making Transformers merchandise a lucrative industry unto itself.</p>"
                )
            );

            foreach ($sections as $section) {
                echo "<section id='" . $section['id'] . "'>";
                echo "<h2>" . $section['title'] . "</h2>";
                echo $section['content'];
                echo "</section>";
            }
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Transformers Fan Website. All rights reserved.</p>
    </footer>
</body>
</html>


