<?php
session_start();        /*Nécessaire pour accéder à la session correspondante*/
// if (isset($_GET['message'])) {
//     echo "<p>".$_GET['message']."</p>";
// }
if (isset($_SESSION['articleRetire'])) {
    echo $_SESSION['articleRetire'];
    unset($_SESSION['articleRetire']);
}

if (isset($_SESSION['panierVide'])) {
    echo $_SESSION['panierVide'];
    unset($_SESSION['panierVide']);
}

if (isset($_SESSION['plusQtt'])) {
    echo $_SESSION['plusQtt'];
    unset($_SESSION['plusQtt']);
}

if (isset($_SESSION['moinsQtt'])) {
    echo $_SESSION['moinsQtt'];
    unset($_SESSION['moinsQtt']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Récapitulatif des produits</title>
</head>
<body>
    <!--<div class="flox"> dans laquelle on inclut le tableau et le menu -->
    <?php
        if (!isset($_SESSION["products"]) || empty($_SESSION["products"])) {
            echo "<p>Aucun produit en session...</p>";
        }
        else {
            echo "<table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
            $totalGeneral = 0;
            $totalQuantite = 0;
            foreach ($_SESSION["products"] as $index => $product) {
                echo "<tr>
                        <td>$index</td>
                        <td>".$product['name']."</td>
                        <td>".number_format($product['price'], 2, ',', '&nbsp;')."&nbsp;€
                        </td>
                        <td>
                            <a class='option' href='traitement.php?action=ajoutQtt&index=$index'>+</a>".$product['qtt']."<a class='option' href='traitement.php?action=retirerQtt&index=$index'>-</a>
                        </td>
                        <td>".number_format($product['total'], 2, ',', '&nbsp;')."&nbsp;€
                        </td>
                        <td>
                            <a class='clear' href='traitement.php?action=retirerArticle&index=$index'>Retirer l'article</a>
                        </td>
                    </tr>";     //Pourquoi remettre l'index dans l'ancre alors que le lien est sur la même ligne --> agit sur une autre page
                $totalGeneral += $product['total'];
                $totalQuantite += $product['qtt'];
                $_SESSION['panier'] = $totalQuantite;
            }
            echo "<tr>
                    <td colspan=4 class='total'>Total général :</td>
                    <td class='total'>
                        <strong>".number_format($totalGeneral, 2, ',', '&nbsp;')."&nbsp;€</strong>
                    </td>
                    <td>
                        <a class='clear' href='traitement.php?action=viderPanier'>Vider le panier</a>
                    </td>
                    </tbody>
                </table>";
        }
    ?>

<div>
    <?php
            echo "<p>Articles en session : ".$_SESSION['panier']."</p>";
            ?>
    </div>

    <div class="menu">
        <ul>
            <li><a href="index.php">Index</a></li>
            <li><a href="recap.php">Récapitulatif</a></li>
        </ul>
    </div>
</body>
</html>