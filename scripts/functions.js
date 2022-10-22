function showBurgerMenu() {
    var x = document.getElementById("burger-menu-container");
    if (x.style.display === "block") {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
}

function hideDetailsBox() {
  var x = document.getElementById("quick-shop-container");
  x.style.display = "none";
}


function showDetailsBox(source, name, price, id) {
  var container = document.getElementById("quick-shop-container");
  var containerImg = document.getElementById("details-box-img");
  var containerName = document.getElementById("product-name");
  var containerPrice = document.getElementById("product-price");
  var currItem = document.getElementById("current-item");
  containerImg.src = source;
  containerName.textContent = name;
  containerPrice.textContent = "$" + price + ".00";
  currItem.value = id;
  container.style.display = "flex";
}

function changeButtonText() {
  var buttonClicked = document.getElementsByClassName("add-to-cart");
  buttonClicked[0].textContent = "Added To Cart";
  setTimeout(changeButtonTextBack, 1000);
}

function changeButtonTextBack() {
  var buttonClicked = document.getElementsByClassName("add-to-cart");
  buttonClicked[0].textContent = "Add To Cart";
}

function removeCartItem(cartItemNum, price) {
  var itemToRemove = document.getElementById(cartItemNum);
  var priceElement = document.getElementById("total-price");
  var oldPrice = priceElement.textContent;
  var oldPriceExtract = '';
  for (let i = 1; i < oldPrice.length - 3; i++) {
    oldPriceExtract += oldPrice.charAt(i);
  }
  var oldPriceStr = (Number(oldPriceExtract) - Number(price)).toString();
  priceElement.textContent = "$" + oldPriceStr + ".00";
  itemToRemove.style.display = "none";
}
