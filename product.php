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
    <?php

        $default_lang = 'sv';
        $default_currency = 'SEK';

        if ($_COOKIE['lang'] == NULL) { //No Cookie Found
            if ($_GET['lang'] !== NULL) {
                setcookie('lang', $_GET['lang'], time() + 86400, "/");
                $lang = $_GET['lang'];
            } else {
                $lang = $default_lang;
            }
        } else { // Cookie Found
            if ($_GET['lang'] == $_COOKIE['lang']) { // If get request is same as cookie
                $lang = $_COOKIE['lang'];
            } else { // If get request is different from the cookie
                setcookie('lang', $_GET['lang'], time() + 86400, "/");
                if ($_GET['lang'] == NULL) {
                    $lang = $_COOKIE['lang'];
                } else {
                    $lang = $_GET['lang'];
                }
            }
        }


        if ($_COOKIE['currency'] == NULL) { //No Cookie Found
            //echo "NO cookie Found";
            if ($_GET['loop_currency'] !== NULL) {
                setcookie('currency', $_GET['loop_currency'], time() + 86400, "/");
                $currency = $_GET['loop_currency'];
            } else {
                $currency = $default_currency;
            }
        } else { // Cookie Found
            //echo "cookie Found";
            if ($_GET['loop_currency'] == $_COOKIE['currency']) { // If get request is same as cookie
                $currency = $_COOKIE['currency'];
            } else { // If get request is different from the cookie
                if ($_GET['loop_currency'] == NULL) {
                    //echo "GET was null";
                    $currency = $_COOKIE['currency'];
                } else {
                    setcookie('currency', $_GET['loop_currency'], time() + 86400, "/");
                   // echo "gettin currency from get request";
                    $currency = $_GET['loop_currency'];
                }
            }
        }
        setcookie('currency', $currency, time() + 86400, "/");
        setcookie('lang', $lang, time() + 86400, "/");

       // var_dump($currency);

    ?>
    <header id="main-header">
        <a href="index.php">
            Webshop
        </a>
    </header>
    <div class="options-container">
        <div id="lang-dropdown">
            <span>Language</span>
            <div class="lang-dropdown-content">
                <a href="product.php?lang=sv&uid=<?=$_GET['uid']?>&currency=<?=$currency?>">Svenska</a>
                <a href="product.php?lang=en&uid=<?=$_GET['uid']?>&currency=<?=$currency?>">English</a>
            </div>
        </div>
        <div id="currency-dropdown">
            <span><?=$currency?></span>
            <div class="currency-dropdown-content">
                <?php 
                    $all_currencies = ['SEK', 'USD', 'NOK', 'GBP', 'EUR', 'CAD'];
                    foreach ($all_currencies as $this_currency) {
                        ?>
                        <a href='product.php?uid=<?=$_GET['uid']?>&currency=<?=$this_currency?>'><?=(string)$this_currency?></a>
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
    $lang = $_COOKIE['lang'];
    
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

    var_dump($currency);
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