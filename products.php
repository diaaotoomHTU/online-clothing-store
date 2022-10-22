<?php
session_start();
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect("localhost", "id17834794_root", "fmvpMqWpnVk&WL5s", "id17834794_urbanclothes");
if (isset($_GET["products"])) {
    if ($_GET["products"] == "bottoms") {
        $type = "bottoms";
    }
    if ($_GET["products"] == "shoes") {
        $type = "shoes";
    }
} else {
    $type = "tops";
}

if (isset($_POST["itemAdded"])) {
    array_push($_SESSION["cart"], $_POST["itemAdded"]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Fonts Start-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!--Fonts End-->
    <link rel="icon" type="image/png" href="assets/favicon/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Shop</title>
</head>
<body>
    <!--Navigation Bar Start-->
    <script src="scripts/functions.js"></script>
    <nav id="navigation-bar">
        <ul id="nav-list">
            <div id="mobile-nav">
                <a href="javascript:void(0);" onclick="showBurgerMenu()"><img src="assets/navigation/hamburger.png" class="icon"></a>
            </div>
            <li><a href="index.html"><img src="assets/navigation/Logo.png" id="logo"></a></li>
            <li class="nav-item"><a href="products.php"><img src="assets/navigation/TopsIcon.png" class="icon"> Tops</a></li>
            <li class="nav-item"><a href="products.php?products=bottoms"><img src="assets/navigation/BottomsIcon.png" class="icon"> Bottoms</a></li>
            <li class="nav-item"><a href="products.php?products=shoes"><img src="assets/navigation/ShoesIcon.png" class="icon"> Shoes</a></li>
            <li class="nav-item"><a href="support.html">Support</a></li>
            <li class="nav-item"><a href="cart.php"><img src="assets/navigation/cart.png" class="icon"></a></li>
            <li id="invis-item"></li>
        </ul>
        <div id="burger-menu-container">
            <ul id="burger-menu-items">
                <li class="burger-menu-item"><a href="products.php" class = "burger-anchor">Tops</a></li>
                <li class="burger-menu-item"><a href="products.php?products=bottoms" class = "burger-anchor">Bottoms</a></li>
                <li class="burger-menu-item"><a href="products.php?products=shoes" class = "burger-anchor">Shoes</a></li>
                <li class="burger-menu-item"><a href="support.html" class = "burger-anchor">Support</a></li>
                <li class="burger-menu-item"><a href="cart.php" class = "burger-anchor">Cart</a></li>
            </ul>
        </div>
    </nav>
    <!--Navigation Bar End-->
    <section id="products">
        <header id="category-name">
        <?php
            if ($type == "tops") {
                echo "Hoodies, Shirts, and Jackets";
            } elseif ($type == "bottoms") {
                echo "Pants and Shorts";
            } else {
                echo "Shoes";
            }
        ?>
        </header>
        <section id="product-rows">
            <?php
            $result = $conn->query("SELECT * FROM products");
            $max = 12;
            if (isset($_GET["page"])) {
                $max *= $_GET["page"];
            }
            $count = $max - 12;
            while ($count < $max && $card = $result->fetch_assoc()) {
                if ($card["type"] == $type && $count < $card["id"]) {
                    echo '<div class="product-rectangle"><a href="javascript:void(0)" onclick="showDetailsBox(' . '\'' . $card["src"] . '\', \'' .  $card["name"] . '\', \'' . $card["price"] . '\', \'' . $card["id"] . '\')"><figure><img src="' . $card["src"] . '" class="product-img"></figure><figcaption class="product-desc">'. $card["name"] . '</figcaption></a></div>';
                    ++$count; 
                }
            }
            ?>
        </section>
    </section>    

    <section id="quick-shop-container">
        <div id="details-box">
            <div id="close-details"><a href="javascript:void(0)" onclick="hideDetailsBox()">X</a></div>
            <div id="product-details">
                <img src="assets/tops/greyShirt.webp" id="details-box-img">
                <div id="written-details">
                    <div id="product-name">Grey Shirt with Buttons</div>
                    <div id="product-price">$50.00</div>
                    <form method="post" target="iframe">
                        <input type="hidden" name="itemAdded" id="current-item" value="0">
                        <button class="add-to-cart" onclick="changeButtonText()">Add To Cart</button>
                    </form>
                    <!--iFrame to submit form without page refresh-->
                    <iframe name="iframe" class="hidden-iframe" src="about:blank"></iframe>
                </div>
            </div>
        </div>
    </section>

    <section id="page-navigation">
        <?php
            if(isset($_GET["page"]) && $_GET["page"] != 1) {
                $previousPage = $_GET["page"] - 1;
                echo '<a href="products.php?page=' . $previousPage . '">< </a>';
            }
        ?>

        
        <?php
        if (isset($_GET["page"])) {
            echo '<p>&nbsp&nbspPage ' . $_GET["page"] . '&nbsp&nbsp</p>';
        } else {
            echo '<p>&nbsp&nbspPage 1&nbsp&nbsp</p>';
        }
        ?>
        
        <?php
            $query = "SELECT COUNT(id) as totalItems FROM `products` WHERE type = '$type'";
            $result = $conn->query($query);
            $fetch = $result->fetch_assoc();
            if($fetch["totalItems"] > $count) {
                if (isset($_GET["page"])) {
                    $nextPage = $_GET["page"] + 1;
                    echo '<a href="products.php?page=' . $nextPage . '">></a>';
                } else {
                    echo '<a href="products.php?page=' . 2 . '">></a>';
                }
                
            }
        ?>
    </section>

    <!--Copyright Bar Start-->
    <footer id="copyright">
        <div>
            Ⓒ Copyright 2021-2022 Urban Clothes
            <br>All rights reserved.
        </div>
    </footer>
    <!--Copyright Bar End-->
    
</body>
</html>