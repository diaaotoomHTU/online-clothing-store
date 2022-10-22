<?php
session_start();

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect("localhost", "id17834794_root", "fmvpMqWpnVk&WL5s", "id17834794_urbanclothes");

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $address = $_GET['address'];
    $query = "INSERT INTO `orders`(`name`, `phone`, `address`) VALUES ('$name','$phone','$address')";
    $conn->query($query);
    $query = 'SELECT * FROM orders ORDER BY id DESC LIMIT 1';
    $result = $conn->query($query);
    $lastOrder = $result->fetch_assoc();
    $orderid = $lastOrder["id"];
    $finalItems = array();
    foreach ($_SESSION["cart"] as $item) {
        if (isset($finalItems[$item])) {
            $finalItems[$item]++;
        } else {
            $finalItems[$item] = 1;
        }
    }
    foreach ($finalItems as $item => $quantity) {
        $query = "INSERT INTO `order_product` VALUES ('$orderid','$item','$quantity')";
        $conn->query($query);
    }
} else {
    header("location: index.html");
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
    <title>Receipt</title>
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

    <section id="receipt-container">
        <div id="thankyou"><b>Thank you.</b></div>
        <div id="success">Your purchase has been made succesfully</b></div>
        <div id="final-receipt">
            <header id="final-receipt-header">Receipt</header>
            <?php
            foreach ($_SESSION["cart"] as $productId) {
                $query = "SELECT `name`, `price` FROM `products` WHERE id = $productId";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                echo '<div class="final-itemstotal">
                        <div class="final-item">' . $row['name'] . '</div>
                        <div class="final-total">$' . $row['price'] . '.00</div>
                      </div>';
            }
            ?>
            <?php
            echo '<div id="final-details">
                    <div id="final-name"><b>' . $_GET['name'] . '</b></div>
                    <div id="final-phone"><b>' . $_GET['phone'] . '</b></div>
                    <div id="final-address"><b>' . $_GET['address'] . '</b></div>
                  </div>';
            session_destroy();
            ?>
        </div>
    </section>
    <div id="continue-shopping">Continue browsing products <a href="products.php">here</a>, or return to the <a href="index.html">homepage</a></div>

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