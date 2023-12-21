<?php
include "deconexion.php";
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
        if($_POST["choix"]=="ajouter"){
            ///Ajout de la carte
        }
        elseif($_POST["choix"]=="supprimer"){
            echo("La carte n'y est pas.");
        }
    }
    else{
        if($_POST["choix"]=="ajouter"){
            echo("La carte existe déja");
        }
        elseif($_POST["choix"]=="supprimer"){
            //suppresion de la carte
        }
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
    <form method="POST" action="AjoutCarte.php">
        <label for="nom">nom :</label>
        <input type="text" id="nom" name="nom"><br>
        <label for="choix">choix :</label>
        <select name="choix" id="choix">
            <option value="">--Choisissez--</option>
            <option value="ajouter">ajouter</option>
            <option value="supprimer">supprimer</option>
        </select>
        <input type="submit" value="Valider">
    </form>
</body>
</html>