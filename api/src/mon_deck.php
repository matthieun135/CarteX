<?php
include "VerrificationsRole.php";
include "connexionBDD.php";
$requete1= $connexion->query("SELECT * FROM user");
$utilisateur= $requete1->fetchAll(PDO::FETCH_ASSOC);
for ($i=0; $i <sizeof($utilisateur) ; $i++) { 
    if(password_verify($_COOKIE["pseudo"],$utilisateur[$i]["identifiant"])){
        $id_user=$utilisateur[$i]["id"];
    }
}
if(isset($_POST["id"])){
    $id = intval($_POST["id"]);
}
if (isset($_POST['supprimer'])) {
    $id_carte = $_POST['id_carte'];
    $requete =$connexion->prepare("DELETE FROM deck WHERE id_carte = ? AND id_user= ?;");
    $requete->execute([$id_carte,$id_user]);
}
if (isset($_POST['supprimer_deck'])) {
    $requete =$connexion->prepare("DELETE FROM deck WHERE id_user= ?;");
    $requete->execute([$id_user]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deck</title>
</head>
<body>
    <?php
    include "deconexion.php";
    ?>
    <a href="Connecte.php">Retour au menu</a>
    <?php
    echo("<form method='post' action='mon_deck.php'>");
    echo("<button type='submit' name='supprimer_deck'>Supprimer tout le deck</button>");
    echo("</form>");
    $requete2 = $connexion->prepare("SELECT * FROM deck WHERE id_user=?");
    $requete2->execute([$id_user]);
    $deck= $requete2->fetchAll(PDO::FETCH_ASSOC);
    if(sizeof($deck)==0){
        echo("<h2>Votre deck est vide</h2>");
    }
    foreach ($deck as $cartedeck) {
            // Afficher les détails de chaque carte
            $requete3= $connexion->prepare("SELECT * FROM carte WHERE id=? ");
            $requete3->execute([$cartedeck["id_carte"]]);
            $carte= $requete3->fetch();
            echo "<div>";
            echo "<h2>{$carte['nom']}</h2>";
            echo "<p>Type : {$carte['type']}</p>";
            if($carte['niveau']!=NULL){
                echo "<p>Niveau : {$carte['niveau']}</p>";
            }
            
            // Affichage du prix même s'il a une valeur de  0
            $prix = isset($carte['prix']) ? $carte['prix'] : 0;
            echo "<p>Prix : {$prix}</p>";
            
            // Affichage de la rareté même s'il a une valeur de 0
            $rarete = isset($carte['rarete']) ? $carte['rarete'] : 0;
            echo "<p>Rareté : {$rarete}</p>";

            // Affichage des images
            echo "<img src='{$carte['image_carte']}' alt='{$carte['nom']}' />";
            echo("</form>");
            echo("<form method='post' action='mon_deck.php'>");
            echo("<input type='hidden' name='id_carte' value='{$carte['id']}'>");
            echo("<button type='submit' name='supprimer'>Supprimer</button>");
            echo("</form>");
            echo("</div>");
    }
    ?>
</body>
</html>