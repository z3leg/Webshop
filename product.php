<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Product page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/product.css">
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
            <a href="product.php?lang=sv&uid=<?=$_GET['uid']?>">Svenska</a>
            <a href="product.php?lang=en&uid=<?=$_GET['uid']?>">English</a>
        </div>
    </div>
    <?php

    require(dirname(__FILE__) . '/vendor/autoload.php');
    use Textalk\WebshopClient\Connection;
    $api = Connection::getInstance('default', array('webshop' => 22222));


    $uid = $_GET['uid'];
    $lang = $_GET['lang'];

    $current_article = $api->Article->get($uid);

    $name = $current_article["name"][$lang];
    $img_url = $current_article["images"][0];
    $article_price = $current_article["price"]['current']['SEK'];


    $article_stock = $current_article['stock']['message'][$lang];
    if ($article_stock == NULL) {
        $article_stock = "No information about stock";
    }

    $img_width = 250 * 1.5;
    $img_height = 350 * 1.5;

    ?>
    <div class = "container">
        <img src='<?=$img_url?>' height='<?=$img_height?>' width='<?=$img_width?>'/>
        <p><?=$name?></p>
        <p><?= $article_price ?> SEK</p>
        <p><?= $article_stock ?> </p>
        <br>
    </div>

</body>
</html>