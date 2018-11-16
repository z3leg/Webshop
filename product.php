<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Product page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/product.css">
    <link rel="stylesheet" type="text/css" href="style/options-container.css">
</head>
<body>
    <header id="main-header">
        <a href="index.php?lang=<?=$_GET['lang']?>&currency=<?=$_GET['currency']?>">
            Webshop
        </a>
    </header>
    <div class="options-container">
        <div id="lang-dropdown">
            <span>Language</span>
            <div class="lang-dropdown-content">
                <a href="product.php?lang=sv&uid=<?=$_GET['uid']?>&currency=<?=$_GET['currency']?>">Svenska</a>
                <a href="product.php?lang=en&uid=<?=$_GET['uid']?>&currency=<?=$_GET['currency']?>">English</a>
            </div>
        </div>
        <div id="currency-dropdown">
            <span><?=$_GET['currency']?></span>
            <div class="currency-dropdown-content">
                <?php 
                    $all_currencies = ['SEK', 'USD', 'NOK', 'GBP', 'EUR', 'CAD'];
                    foreach ($all_currencies as $currency) {
                        ?>
                        <a href='product.php?lang=<?=$_GET['lang']?>&uid=<?=$_GET['uid']?>&currency=<?=$currency?>'><?=(string)$currency?></a>
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

    #var_dump($_GET['uid']);
    require(dirname(__FILE__) . '/vendor/autoload.php');
    use Textalk\WebshopClient\Connection;
    $api = Connection::getInstance('default', array('webshop' => 22222));
    
    
    $uid = $_GET['uid'];
    $lang = $_GET['lang'];
    $currency = $_GET['currency'];
    
    $current_article = $api->Article->get($uid);


    $name = $current_article["name"][$lang];
    $img_url = $current_article["images"][0];
    $description = $current_article["description"][$lang];
    $article_price = $current_article["price"]['current'][$currency];


    $article_stock = $current_article['stock']['message'][$lang];
    if ($article_stock == NULL) {
        if ($lang == 'sv') {
            $article_stock = "Ingen information om lager status";
        } elseif ($lang == 'en') {
            $article_stock = "No information about stock";
        }
    }
    if ($img_url == NULL) {
        $img_url = "missing-items/No_Image_Available.png";
    }

    $img_width = 250 * 1.5;
    $img_height = 350 * 1.5;

    ?>
   
   
   <div class="container">
        <img src='<?=$img_url?>' height='<?=$img_height?>' width='<?=$img_width?>'/>
        <div class="prod-info">
            <p><?=$name?></p>
            <p><?= $article_price . " " . $currency?></p>
            <p><?= $article_stock ?> </p>
            <p><?= $description ?> </p>
            <br>
        </div>
    </div>

</body>
</html>