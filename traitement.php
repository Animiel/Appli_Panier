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
                    $_SESSION['panier'] += $product['qtt'];
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
            $index = $_GET['index'];
            $_SESSION["products"][$index]['qtt']++;
            $_SESSION["products"][$index]['total'] += $_SESSION["products"][$index]['price'];
            /*$index est le tableau produit !
            Vue imagée : Products = [pomme, raisin, fraise]
                                    index0  index1  index2
            Donc index0 = pomme[] => accès direct à ses propriétés (exemple: on peut voir $index comme étant pomme[] et accéder à "qtt" directement)*/
            
            header("Location:recap.php");
        die;

        case "retirerQtt":
            $index = $_GET['index'];
            $_SESSION["products"][$index]['qtt']--;
            $_SESSION["products"][$index]['total'] -= $_SESSION["products"][$index]['price'];
            if ($_SESSION["products"][$index]['qtt'] == 0) {
                unset($_SESSION["products"][$index]);
            }
            header("Location:recap.php");
        die;
        
        default:
            header("Location:index.php");
        die;
    }
}
header("Location:index.php");

if (isset($_SESSION["panier"])) {
    $_SESSION['panier'] = 0;
}
header("Location:index.php");
       
?>