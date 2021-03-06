<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Main page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/main.css">
    <link rel="stylesheet" type="text/css" href="style/options-container.css">
</head>
<body>
    <header id="main-header">
        <a href="index.php">
            Webshop
        </a>
    </header>

    <?php 
        $default_lang = 'sv';
        $default_currency = 'SEK';
        if ($_GET['lang'] == NULL) {
            $lang = $default_lang;
        } else {
            $lang = $_GET['lang'];
        }
        if ($_GET['currency'] == NULL) {
            $currency = $default_currency;
        } else {
            $currency = $_GET['currency'];
        }

    ?>
    <div class="options-container">
        <div id="lang-dropdown">
            <span>Language</span>
            <div class="lang-dropdown-content">
                <a href="index.php?lang=<?='sv'?>&currency=<?=$currency?>">Svenska</a>
                <a href="index.php?lang=<?='en'?>&currency=<?=$currency?>">English</a>
            </div>
        </div>
        <div id="currency-dropdown">
            <span><?=$currency?></span>
            <div class="currency-dropdown-content">
                <?php 
                    $all_currencies = ['SEK', 'USD', 'NOK', 'GBP', 'EUR', 'CAD'];
                    foreach ($all_currencies as $currency) {
                        ?>
                        <a href='index.php?lang=<?=$lang?>&currency=<?=$currency?>'><?=(string)$currency?></a>
                <?php } ?>
            </div>
        </div>
        <div id="searchbar">
            <form action="searched_products.php?lang=<?=$lang?>&currency=<?=$currency?>">
                <input type="text" name="search_name" placeholder="Search.." method="GET">
            </form>
        </div>
    </div>


    <?php
    require(dirname(__FILE__) . '/vendor/autoload.php');
    use Textalk\WebshopClient\Connection;
    $api = Connection::getInstance('default', array('webshop' => 22222));


    #GETS FROM URL
    $lang = $_GET['lang'];
    $currency = $_GET['currency'];
    if ($lang == NULL) {
        $lang = $default_lang;
    }
    if ($currency == NULL) {
        $currency = $default_currency;
    }



    $articles_from_query = $api->Article->list(
        [
            "uid" => true,
            "name" => "sv",
            "images" => true
        ],
        [
            "limit" => 200
        ]
    );


    #SHOW ALL ARTICLES
    foreach ($articles_from_query as $i => $current_article) {

        #var_dump($current_article);

        $name = $current_article["name"][$lang];
        $img_url = $current_article["images"][0];

        if ($name == NULL) {
            $name = $current_article["name"][$default_lang];
            if ($name == NULL) {
                $name = "No product name";
            }
        }
        if ($img_url == NULL) {
            $img_url = "missing-items/No_Image_Available.png";
        }


            ?>
        <div class="container">
            <a href="product.php?uid=<?=$current_article['uid']?>&lang=<?=$lang?>&currency=<?=$currency?>">
                <img src="<?= $img_url ?>" draggable="false" alt="<?= $name ?>" 
                "/>
            </a>
            <h3> <?= $name ?> </h3>
            <br>
        </div>
    <?php }
    // Show all information, defaults to INFO_ALL
    # phpinfo();
    ?>
</body>
</html>