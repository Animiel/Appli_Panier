<?php

session_start();

//preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $name) --> sert à vérifier si au moins une lettre ET un chiffre se trouve dans la string

if (isset($_GET['action'])) {

    switch ($_GET['action']) {

        case "ajouterProduit":
            if (isset($_POST['submit'])) {
                $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
                if (($name) && ($price && $price > 0) && ($qtt && $qtt > 0)) {
                    $product = [
                        "name" => $name,
                        "price" => $price,
                        "qtt" => $qtt,
                        "total" => $price * $qtt
                    ];
                    $_SESSION["products"][] = $product;
                    $_SESSION['panier'] += $product['qtt'];
                    $_SESSION['ajoutArticle'] = "<p class='ajoutArticle'>
                    Vous avez ajouté ".$product['qtt']." ".$product['name']." a votre panier.
                    </p>";
                }
                else {
                    $_SESSION['invalidite'] = "<p class='invalidite'>
                    Une information a mal été renseignée. Veillez à mettre un nom en toute lettre <strong>UNIQUEMENT</strong> et un prix et une quantité <strong>POSITIVE</strong>
                    </p>";
                }
            }
            header("Location:index.php");
            /* 
            $messageSucces = urlencode("...");
            header("Location:index.php?message=".$messageSucces);
            est une option possible, mais impossible de désafficher le message puisque c'est une partie intégrante du lien, donc le refresh utilise le même lien.
            Privilégier la deuxième option :
            $_SESSION['name'] = "..."; et l'unset sur la page (code plus long mais plus accessible et modifiable)       
            */
        die;

        case "viderPanier":
            unset($_SESSION["products"]);
            $_SESSION['panierVide'] = "<p class='panierVide'>
            Votre panier a été vidé.
            </p>";
            $_SESSION['panier'] = 0;
            header("Location:recap.php");
        die;

        case "retirerArticle":
            $index = $_GET['index'];
            unset($_SESSION["products"][$index]);
            $_SESSION['articleRetire'] = "<p class='articleRetire'>
            Le produit ".$_SESSION['products'][$index]['name']." a été supprimer du panier.
            </p>";
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
            $_SESSION['plusQtt'] = "<p class='plusQtt'>
            Vous avez ajouté 1 ".$_SESSION['products'][$index]['name']." a votre panier.
            </p>";
            header("Location:recap.php");
        die;

        case "retirerQtt":
            $index = $_GET['index'];
            $_SESSION["products"][$index]['qtt']--;
            $_SESSION["products"][$index]['total'] -= $_SESSION["products"][$index]['price'];
            if ($_SESSION["products"][$index]['qtt'] == 0) {
                unset($_SESSION["products"][$index]);
            }
            $_SESSION['moinsQtt'] = "<p class='moinsQtt'>
            Vous avez retiré 1 ".$_SESSION['products'][$index]['name']." de votre panier.
            </p>";
            header("Location:recap.php");
        die;
        
        default:
        $_SESSION['actionIntrouvable'] = "<p class='actionIntrouvable'>
            L'action demandée est introuvable ou inexistante.
            </p>";
            header("Location:index.php");
        die;
    }
}
header("Location:index.php");

if (isset($_SESSION["panier"])) {
    $_SESSION['panier'] = 0;
}
else {
    $_SESSION['panier'] = 0;
}
/*On peut aussi utiliser l'écriture ternaire :
$panier = (isset($_SESSION['panier'])) ? "<p>Articles en session : ".$_SESSION['panier']."</p>" : null;echo $panier;
*/
header("Location:index.php");

if(isset($_FILES['file'])) {
    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    $tabExtension = explode('.', $name);        //tabExtension est un tableau qui contiendra toutes les parties de $name à chaque fois qu'il rencontre un point
    $extension = strtolower(end($tabExtension));        //end(tabExtension) permet d'accéder au dernier élément du tableau
    $extensions = ["jpg", "png", "jpeg", "gif"];
    $maxSize = 400000;

    if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
        $uniqueName = uniqid('', true);         //crée un nom unique pour éviter que les fichiers soient écrasés en cas de nom identiques
        $file = $uniqueName.".".$extension;
        move_uploaded_file($tmpName, 'img/'.$file);
    }
    else {
        echo "Une erreur est survenue.";
    }

}
       
?>