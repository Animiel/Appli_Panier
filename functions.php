<?php

function totalQtt() {
    $_SESSION['panier'] = 0;
    foreach ($_SESSION['products'] as $product) {
        $_SESSION['panier'] += $product['qtt']; 
    }
}

function afficherMessage() {
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
?>