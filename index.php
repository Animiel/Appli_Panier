<?php
session_start();
// if (isset($_GET['message'])) {
//     echo "<p>".$_GET['message']."</p>";
//     unset($_GET['message']);
// }

// if (isset($_SESSION['invalidite'])) {
//     echo $_SESSION['invalidite'];
//     unset($_SESSION['invalidite']);
// }

// if (isset($_SESSION['ajoutArticle'])) {
//     echo $_SESSION['ajoutArticle'];
//     unset($_SESSION['ajoutArticle']);
// }

// if (isset($_SESSION['bouton'])) {
//     echo $_SESSION['bouton'];
//     unset($_SESSION['bouton']);
// }
require "functions.php";
afficherMessage();
?>

    <div class="container">
    <h1>Ajouter un produit</h1>
    <form action="traitement.php?action=ajouterProduit" method="post" enctype="multipart/form-data">        <!-- le formulaire form agit sur la page traitement par le biais de la méthode post-->
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
            <label>
                Image :
                <input type="file" name="file">
            </label>
        </p>
        <label>
            Description du produit :
            <textarea name='description' rows='5' cols='50'></textarea>
        </label>
        <p>
            <input type="submit" name="submit" value="Ajouter le produit">
        </p>
    </form>
    

<?php
$contenu = ob_get_clean();      //On stocke tout ce qui se situe entre le ob_start et le clean
$title = "Achats";
require "template.php";     //On demande le fichier template puisque le ob_start empêche l'affichage de ce qui se trouve en lui --> en appelant template sur la page index.php il ne peut pas y avoir de confusion avec la page recap (qui contient exactement les même noms de variables)
?>