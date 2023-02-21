<?php
session_start();        /*Nécessaire pour accéder à la session correspondante*/
ob_start();

// if (isset($_GET['message'])) {
//     echo "<p>".$_GET['message']."</p>";
// }

// if (isset($_SESSION['articleRetire'])) {
//     echo $_SESSION['articleRetire'];
//     unset($_SESSION['articleRetire']);
// }

// if (isset($_SESSION['panierVide'])) {
//     echo $_SESSION['panierVide'];
//     unset($_SESSION['panierVide']);
// }

// if (isset($_SESSION['plusQtt'])) {
//     echo $_SESSION['plusQtt'];
//     unset($_SESSION['plusQtt']);
// }

// if (isset($_SESSION['moinsQtt'])) {
//     echo $_SESSION['moinsQtt'];
//     unset($_SESSION['moinsQtt']);
// }
require "functions.php";
afficherMessage();

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
            // var_dump($product['description']);
            echo "<tr>
                    <td>$index</td>
                    <td class='prod-name'><strong>".$product['name']."</strong><br><img class='img' src='img/".$product['image']."'><br>
                    <p><small>".$product['description']."</small></p>
                    </td>
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
$contenu = ob_get_clean();
$title = "Panier";
require "template.php";
?>