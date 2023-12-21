<?php
include "déconexion.php";
//redirige vers la page accueil si la personne connecté n'est pas un admin.
if (isset($_COOKIE["rang"]) && $_COOKIE["rang"]=="utilisateur"){
    header("Location: Carte.php");
}
if(isset($_POST["nom"]) && !$_POST["nom"]==""){
    include "connexionBDD.php";
    $nom= $_POST["nom"];
    $estdeja= false;
    $requete= $connexion->query("SELECT nom FROM carte");
    $cartes= $requete->fetchAll(PDO::FETCH_ASSOC);
    for ($i=0; $i < sizeof($cartes); $i++) { 
        if($nom==$cartes[$i]["nom"]){
            $estdeja= true;
            break;
        }
    }
    if(!$estdeja){
        ///Ajout de la carte
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout</title>
</head>
<body>
    <a href="Carte.php"><button class="bouton" id="btn-Accueil">Carte</button></a>
    <h1>Bienvenue quel carte shouaitez vous ajouter.</h1>
    <?php
        if(isset($estdeja)&&$estdeja){
            echo("La carte existe déja dedans.</br>");
        }
    ?>
    <form method="POST" action="AjoutCarte.php">
        <label for="nom">nom :</label>
        <input type="text" id="nom" name="nom"><br>
        <input type="submit" value="Valider">
    </form>
</body>
</html>