<?php
session_start();
if (isset($_GET['message'])) {
    echo "<p>".$_GET['message']."</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Ajout produit</title>
</head>
<body>
    <div class="container">
    <h1>Ajouter un produit</h1>
    <form action="traitement.php?action=ajouterProduit" method="post">        <!-- le formulaire form agit sur la page traitement par le biais de la méthode post-->
        <p>
            <label>
                Nom du produit :
                <input type="text" name="name">
            </label>
        </p>
        <p>
            <label>
                Prix du produit :
                <input type="number" step="any" name="price">
            </label>
        </p>
        <p>
            <label>
                Quantité désirée :
                <input type="number" name="qtt" value="1">
            </label>
        </p>
        <p>
            <input type="submit" name="submit" value="Ajouter le produit">
        </p>
        <div class="menu">
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><a href="recap.php">Récapitulatif</a></li>
            </ul>
        </div>
        <div>
            <?php
            echo "<p>Articles en session :".$_SESSION['panier']."</p>";
            ?>
        </div>
    </form>
    </div>

</body>
</html>