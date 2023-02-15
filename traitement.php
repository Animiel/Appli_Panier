<?php

session_start();

$messageErreur = urlencode("<p class='erreurPage'>Accès à cette page refusé.");
$messageSucces = urlencode("Opération réalisée avec succès.");

if (isset($_GET['action'])) {

    switch ($_GET['action']) {

        case "ajouterProduit":
            if (isset($_POST['submit'])) {
                $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
                if ($name && ($price && $price > 0) && ($qtt && $qtt > 0)) {
                    $product = [
                        "name" => $name,
                        "price" => $price,
                        "qtt" => $qtt,
                        "total" => $price * $qtt
                    ];
                    $_SESSION["products"][] = $product;
                    $_SESSION['panier'] += $product['qtt'];
                }
                else {
                    $_SESSION['invalidite'] = "Une information a mal été renseignée. Veillez à mettre un nom en toute lettre <strong>UNIQUEMENT</strong> et un prix et une quantité <strong>POSITIVE</strong>";
                }
            }
            header("Location:index.php?message=".$messageSucces);
        die;

        case "viderPanier":
            unset($_SESSION["products"]);
            header("Location:recap.php?message=".$messageSucces);
        die;

        case "retirerArticle":
            $index = $_GET['index'];
            unset($_SESSION["products"][$index]);
            header("Location:recap.php?message=".$messageSucces);
        die;

        case "ajoutQtt":
            $index = $_GET['index'];
            $_SESSION["products"][$index]['qtt']++;
            $_SESSION["products"][$index]['total'] += $_SESSION["products"][$index]['price'];
            /*$index est le tableau produit !
            Vue imagée : Products = [pomme, raisin, fraise]
                                    index0  index1  index2
            Donc index0 = pomme[] => accès direct à ses propriétés (exemple: on peut voir $index comme étant pomme[] et accéder à "qtt" directement)*/
            
            header("Location:recap.php?message=".$messageSucces);
        die;

        case "retirerQtt":
            $index = $_GET['index'];
            $_SESSION["products"][$index]['qtt']--;
            $_SESSION["products"][$index]['total'] -= $_SESSION["products"][$index]['price'];
            if ($_SESSION["products"][$index]['qtt'] == 0) {
                unset($_SESSION["products"][$index]);
            }
            header("Location:recap.php?message=".$messageSucces);
        die;
        
        default:
            header("Location:index.php?message=".$messageErreur);
        die;
    }
}
header("Location:index.php?message=".$messageErreur);

if (isset($_SESSION["panier"])) {
    $_SESSION['panier'] = 0;
}
header("Location:index.php?message=".$messageErreur);
       
?>