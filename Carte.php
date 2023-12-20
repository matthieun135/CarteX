<?php
// Inclure le fichier de connexion à la base de données
include "connexionBDD.php";

// Récupérer les filtres depuis le formulaire
$terme_Recherche = isset($_GET['termeRecherche']) ? $_GET['termeRecherche'] : '';
$typeFiltre = isset($_GET['typeFiltre']) ? $_GET['typeFiltre'] : 'nom';
$ordre_de_Tri = isset($_GET['ordre_de_Tri']) ? $_GET['ordre_de_Tri'] : 'asc';

// Construire la requête SQL de base
$sql = "SELECT * FROM carte";

// Ajouter les filtres à la requête SQL
if (!empty($terme_Recherche)) {
    $sql .= " AND nom LIKE '%$terme_Recherche%'";
}

// on ajoute une requete SQL pour faire le trie par nom ou par prix ou par type
switch ($typeFiltre) {
    case 'nom':
        // trier par nom
        $sql .= " ORDER BY nom " . ($ordre_de_Tri === 'asc' ? 'ASC' : 'DESC');
        break;
        // trier par prix
    case 'prix':
        $sql .= " ORDER BY Prix " . ($ordre_de_Tri === 'asc' ? 'ASC' : 'DESC');
        break;
        //Trier par type
    case 'type':
        $sql .= " ORDER BY type " . ($ordre_de_Tri === 'asc' ? 'ASC' : 'DESC');
        break;
    default:
        // trier par nom
        $sql .= " ORDER BY nom " . ($ordre_de_Tri === 'asc' ? 'ASC' : 'DESC');
}

// Exécuter la requête SQL
$requete = $connexion->query($sql);
$cartes = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cartes</title>
    <style>
    </style>
</head>
<body>

    <h1>Liste des Cartes</h1>

    <!-- c'est un formulaire de filtres -->
    <form method="get" action="">
        <label for="termeRecherche">Rechercher par nom :</label>
        <input type="text" name="termeRecherche" value="<?= $termeRecherche ?>">

        <label for="typeFiltre">Trier par :</label>
        <select name="typeFiltre">
            <option value="nom" <?= $typeFiltre == 'nom' ? 'selection' : '' ?>>Nom</option>
            <option value="prix" <?= $typeFiltre == 'prix' ? 'selection' : '' ?>>Prix</option>
            <option value="type" <?= $typeFiltre == 'type' ? 'selection' : '' ?>>Type</option>
        </select>

        <label for="ordre_de_Tri">Ordre :</label>
        <select name="ordre_de_Tri">
            <option value="asc" <?= $ordre_de_Tri == 'asc' ? 'selection' : '' ?>>Croissant</option>
            <option value="desc" <?= $ordre_de_Tri == 'desc' ? 'selection' : '' ?>>Décroissant</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <?php
    // Affichage des cartes filtrées et triées
    if (count($cartes) > 0) {
        foreach ($cartes as $carte) {
            // Afficher les détails de chaque carte
            echo "<div>";
            echo "<h2>{$carte['nom']}</h2>";
            echo "<p>Type : {$carte['type']}</p>";
            echo "<p>Niveau : {$carte['niveau']}</p>";
            
            // Affichage du prix meme si il a une valeur de  0
            $prix = isset($carte['Prix']) ? $carte['Prix'] : 0;
            echo "<p>Prix : {$prix}</p>";
            
            // Affichage de la rarete meme si il a une valeur de 0
            $rarete = isset($carte['rarete']) ? $carte['rarete'] : 0;
            echo "<p>Rareté : {$rarete}</p>";

            // Affichage des images
            echo "<img src='{$carte['image_carte']}' alt='{$carte['nom']}' />";
            echo "</div>";
        }
    } else {
        echo "<p>Aucune carte n'a été trouvée.</p>";
    }
    ?>

    <a href="AjoutCarte.php">Ajouter une nouvelle carte</a>
</body>
</html>
