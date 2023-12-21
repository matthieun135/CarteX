<link rel="stylesheet" href="AjoutCarte.css">
<?php

//redirige vers la page accueil si la personne connectée n'est pas un admin.
if (isset($_COOKIE["rang"]) && $_COOKIE["rang"] == "utilisateur") {
    header("Location: Connecte.php");
}

if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
    include "connexionBDD.php";

    
    $nom = htmlspecialchars($_POST["nom"], ENT_QUOTES, 'UTF-8');

    // Vérifie si la carte existe déjà
    $requete = $connexion->prepare("SELECT nom FROM carte WHERE nom = :nom");
    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
    $requete->execute();

    $estDeja = ($requete->rowCount() > 0);

    if (!$estDeja) {
        // Ajout de la carte
        $requeteInsertion = $connexion->prepare("INSERT INTO carte (nom, type, image_carte, niveau, description, prix, rarete) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $nom= $_POST["nom"];
        $type= $_POST["type"];
        $image_carte= $_POST["image_carte"];
        $niveau= $_POST["niveau"];
        $description= $_POST["description"];
        $prix= floatval($_POST["prix"]);
        $rarete= $_POST["rarete"];

        if ($requeteInsertion->execute([$nom, $type, $image_carte, $niveau, $description, $prix, $rarete])) {
            echo "La carte a été ajoutée avec succès.";
        } else {
            echo "Erreur lors de l'ajout de la carte : " . implode(", ", $requeteInsertion->errorInfo());
        }
    } else {
        echo "La carte existe déjà dans la base de données.";
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
<a href="Connecte.php"><button class="bouton" id="btn-Accueil">Carte</button></a>
    <h1>Bienvenue, quelle carte souhaitez-vous ajouter.</h1>
    <form method="POST" action="AjoutCarte.php" class="card">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="type">Type :</label>
        <input type="text" id="type" name="type" required><br>

        <label for="rarete">Rareté :</label>
        <input type="text" id="rarete" name="rarete" required><br>

        <label for="niveau">Niveau :</label>
        <input type="number" id="niveau" name="niveau" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="prix">Prix :</label>
        <input type="text" id="prix" name="prix" required><br>

        <label for="image_carte">URL de l'image :</label>
        <input type="text" id="image_carte" name="image_carte" required><br>

        <input type="submit" value="Valider">
    </form>
</body>
</html>