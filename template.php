<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" type="text/css" rel="stylesheet">
    <title>Magasin | <?= $title ?></title>
</head>
<body>
    <div class="menu">
        <ul>
            <li><a href="index.php">Index</a></li>
            <li><a href="recap.php">Récapitulatif</a></li>
            <li><p>Panier <?php echo $_SESSION['panier'] ?></p></li>
        </ul>
    </div>
    
    <!--<div class="flox"> dans laquelle on inclut le tableau et le menu -->
    <?= $contenu ?>         <!-- On appelle contenu mais pas de conflit pour choisir quel contenu de quelle page, puisque c'est template qui sera appelée sur la page en question et NON PAS les variables qui sont appelées sur template -->

</body>
</html>