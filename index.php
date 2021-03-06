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
                
                //setcookie('currency', $_GET['loop_currency'], time() + 86400, "/");
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
                    $currency = $_COOKIE['currency'];
                } else {
                    setcookie('currency', $_GET['loop_currency'], time() + 86400, "/");
                    $currency = $_GET['loop_currency'];
                }
            }
        }
        setcookie('currency', $currency, time() + 86400, "/");
        setcookie('lang', $lang, time() + 86400, "/");


        // var_dump($_GET['currency']);
        // var_dump($_COOKIE['currency']);
        // var_dump($currency);

        // var_dump($_GET['lang']);
        // var_dump($_COOKIE['lang']);
        // var_dump($lang);
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
                    foreach ($all_currencies as $loop_currency) {
                        ?>
                        <a href='index.php?currency=<?=$loop_currency?>'><?=(string)$loop_currency?></a>
                <?php
                    }
                ?>
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
            <a href="product.php?uid=<?=$current_article['uid']?>">
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