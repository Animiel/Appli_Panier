<?php

session_start();



if (isset($_GET['action'])) {

    switch ($_GET['action']) {

        case "ajouterProduit":
            if (isset($_POST['submit'])) {
                $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

                if ($name && $price && $qtt) {
                    $product = [
                        "name" => $name,
                        "price" => $price,
                        "qtt" => $qtt,
                        "total" => $price * $qtt
                    ];
                    $_SESSION["products"][] = $product;
                }
            }
            header("Location:index.php");
        die;

        case "viderPanier":
            unset($_SESSION["products"]);
            header("Location:recap.php");
        die;

        case "retirerArticle":
            $index = $_GET['index'];
            unset($_SESSION["products"][$index]);
            header("Location:recap.php");
        die;

        case "ajoutQtt":
            $_SESSION["products"][$produit['qtt']] += 1;
        die;

        case "retirerQtt":
        die;
        
        default:
            header("Location:index.php");
        die;
    }
}

header("Location:index.php");
       
?>