<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Main page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>
    <header id="main-header">
        <a href="index.php">
            Webshop
        </a>
    </header>
    <div class="dropdown">
        <span>Language</span>
        <div class="dropdown-content">
            <a href="index.php?lang=<?='sv'?>">Svenska</a>
            <a href="index.php?lang=<?='en'?>">English</a>
        </div>
    </div>


    <?php
    require(dirname(__FILE__) . '/vendor/autoload.php');
    use Textalk\WebshopClient\Connection;
    $api = Connection::getInstance('default', array('webshop' => 22222));
    $default_lang = 'sv';

    $lang = $_GET['lang'];
    if ($lang == NULL) {
        $lang = "sv";
    }

    $articles_from_query = $api->Article->list(
        [
            "uid" => true,
            "name" => "sv",
            "images" => true
        ],
        [
            "limit" => 56 
        ]
    );

    foreach ($articles_from_query as $i => $current_article) {
        //$current_article = $articles_from_query[$i];

        $name = $current_article["name"][$lang];
        if ($name == NULL) {
            $name = $current_article["name"][$default_lang];
        }
        #var_dump($current_article["name"]);
        $img_url = $current_article["images"][0];
        $img_width = 250;
        $img_height = 350;
        if ($img_url == NULL || $name == NULL) {
            echo "Insufficent product info";
        } else {



            ?>
        <div class="container">
            <a href="product.php?uid=<?=$current_article['uid']?>&lang=<?=$lang?>">
                <img src="<?= $img_url ?>" draggable="false" alt="<?= $name ?>" 
                height="<?= $img_height ?>" width="<?= $img_width ?>"/>
            </a>
            <h3> <?= $name ?> </h3>
            <br>
        </div>
    <?php }
    }
    ?>
</body>
</html>