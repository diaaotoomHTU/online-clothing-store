<?php
session_start();
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect("localhost", "id17834794_root", "fmvpMqWpnVk&WL5s", "id17834794_urbanclothes");

if (isset($_POST["cartItemNum"])) {
    unset($_SESSION["cart"][$_POST["cartItemNum"]]);
} else {
    $_SESSION["cart"] = array_values($_SESSION["cart"]);
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
    <title>Cart</title>
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
    <section id="cart-page-container">
        <form action="receipt.php" method="get">
            <header class="form-head">Enter your details to confirm purchase</header>
            <label for="name">Name: </label><br>
            <input type="text" id="name" name="name" required><br><br><br>
            <label for="phone">Phone Number: </label><br>
            <input type="text" id="phone" name="phone" required><br><br><br>
            <label for="address">Address: </label><br>
            <input type="text" id="address" name="address" required><br><br><br>
            <button id="submit-details">Submit</button>
        </form>
        <div id="current-cart">
            <header class="form-head">Your Cart:</header>
            <div id="cart-columns">
                <div id="cart-name">Name</div>
                <div id="cart-total">Price</div>
            </div>
            <hr>
            <?php
            $totalPrice = 0;
            $cartItemNum = 0;
            foreach ($_SESSION["cart"] as $item) {
                $result = $conn->query('SELECT * FROM `products` WHERE `id` = ' . $item);
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $totalPrice += $row["price"];
                    echo '<form method="post" target="iframe" id="' . $cartItemNum . '"><div class="cart-item">
                        <div class="item-nameprice">
                            <div class="item-name">' . $row["name"] . '</div>
                            <div class="item-price">$' . $row["price"] . '.00</div>
                        </div>
                        <div class="remove-item-container">
                            <div class="remove-item-container-hidden">hidden</div>
                            <input type="hidden" name="cartItemNum" value="' . $cartItemNum . '">
                            <button class="remove-item" onclick="removeCartItem(\'' . $cartItemNum . '\', \'' . $row["price"] . '\')">Remove</button>
                        </div>
                    </div></form>';
                    ++$cartItemNum;
                }         
            }
            ?>
            <iframe name="iframe" class="hidden-iframe" src="about:blank"></iframe>
            <hr>
            <div id="total-price"><?php echo "$$totalPrice.00"?></div>
        </div>
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