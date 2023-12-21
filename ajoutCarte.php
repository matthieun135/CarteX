<?php
include "deconnexion.php";

//redirige vers la page accueil si la personne connectée n'est pas un admin.
if (isset($_COOKIE["rang"]) && $_COOKIE["rang"] == "utilisateur") {
    header("Location: Carte.php");
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
        $requeteInsertion = $connexion->prepare("INSERT INTO carte (nom, type, image_carte, niveau, description, Prix, rarete) VALUES (:nom, :type, :image_carte, :niveau, :description, :Prix, :rarete)");

        $requeteInsertion->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requeteInsertion->bindParam(':type', $_POST["type"], PDO::PARAM_STR);
        $requeteInsertion->bindParam(':image_carte', $_POST["image_carte"], PDO::PARAM_STR);
        $requeteInsertion->bindParam(':niveau', $_POST["niveau"], PDO::PARAM_INT);
        $requeteInsertion->bindParam(':description', $_POST["description"], PDO::PARAM_STR);
        $requeteInsertion->bindParam(':Prix', $_POST["prix"], PDO::PARAM_STR);
        $requeteInsertion->bindParam(':rarete', $_POST["rarete"], PDO::PARAM_STR);


        if ($requeteInsertion->execute()) {
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
    <a href="Carte.php"><button class="bouton" id="btn-Accueil">Carte</button></a>
    <h1>Bienvenue, quelle carte souhaitez-vous ajouter ?</h1>

    <form method="POST" action="AjoutCarte.php">

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

</form>

    </form>
</body>
</html>
