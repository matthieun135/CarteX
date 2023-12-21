<?php
// Inclure le fichier de connexion à la base de données
include "connexionBDD.php";

// Récupérer les filtres depuis le formulaire
$recherche = isset($_GET['termeRecherche']) ? $_GET['termeRecherche'] : '';
$typeFiltre = isset($_GET['Filtre']) ? $_GET['Filtre'] : 'nom';
$ordre_de_tri = isset($_GET['Tri']) ? $_GET['Tri'] : 'asc';
$rareteFiltre = isset($_GET['rarete_Filtre']) ? $_GET['rarete_Filtre'] : '';

// Construire la requête SQL de base
$sql = "SELECT * FROM carte WHERE 1";

// Ajouter les filtres à la requête SQL
if (!empty($recherche)) {
    $sql .= " AND nom LIKE '%$recherche%'";
}

if (!empty($rareteFiltre)) {
    $sql .= " AND rarete = '$rareteFiltre'";
}

// Requete SQL pour pour pouvoir trier par nom par prix par type
switch ($typeFiltre) {
    case 'nom':
        $sql .= " ORDER BY nom " . ($ordre_de_tri === 'asc' ? 'ASC' : 'DESC');
        break;
    case 'prix':
        $sql .= " ORDER BY Prix " . ($ordre_de_tri === 'asc' ? 'ASC' : 'DESC');
        break;
    case 'type':
        $sql .= " ORDER BY type " . ($ordre_de_tri === 'asc' ? 'ASC' : 'DESC');
        break;
    default:
        // trier par nom
        $sql .= " ORDER BY nom " . ($ordre_de_tri === 'asc' ? 'ASC' : 'DESC');
}

// Exécution de  la requête SQL
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

    <form method="get" action="">
        <label for="termeRecherche">Rechercher par nom :</label>
        <input type="text" name="termeRecherche" value="<?= $recherche ?>">

        <label for="Filtre">Trier par :</label>
        <select name="Filtre">
            <option value="nom" <?= $typeFiltre == 'nom' ? 'selected' : '' ?>>Nom</option>
            <option value="prix" <?= $typeFiltre == 'prix' ? 'selected' : '' ?>>Prix</option>
            <option value="type" <?= $typeFiltre == 'type' ? 'selected' : '' ?>>Type</option>
        </select>

        <label for="Tri">Ordre :</label>
        <select name="Tri">
            <option value="asc" <?= $ordre_de_tri == 'asc' ? 'selected' : '' ?>>Croissant</option>
            <option value="desc" <?= $ordre_de_tri == 'desc' ? 'selected' : '' ?>>Décroissant</option>
        </select>

        <label for="rarete_Filtre">Filtrer par rareté :</label>
        <select name="rarete_Filtre">
            <option value="" <?= $rareteFiltre == '' ? 'selected' : '' ?>>Toutes les raretés</option>
            <option value="Common" <?= $rareteFiltre == 'Common' ? 'selected' : '' ?>>Common</option>
            <option value="Rare" <?= $rareteFiltre == 'Rare' ? 'selected' : '' ?>>Rare</option>
            <option value="Super Rare" <?= $rareteFiltre == 'Super Rare' ? 'selected' : '' ?>>Super Rare</option>
            <option value="Ultra Rare" <?= $rareteFiltre == 'Ultra Rare' ? 'selected' : '' ?>>Ultra Rare</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <?php
    // Afficher les cartes filtrées et triées
    if (count($cartes) > 0) {
        foreach ($cartes as $carte) {
            // Afficher les détails de chaque carte
            echo "<div>";
            echo "<h2>{$carte['nom']}</h2>";
            echo "<p>Type : {$carte['type']}</p>";
            echo "<p>Niveau : {$carte['niveau']}</p>";
            
            // // Affichage du prix avec meme si le prix est de 0
            $prix = isset($carte['Prix']) ? $carte['Prix'] : 0;
            echo "<p>Prix : {$prix}</p>";
            
            // Affichage de la rareté avec meme si la rarete est de 0
            $rarete = isset($carte['rarete']) ? $carte['rarete'] : 0;
            echo "<p>Rareté : {$rarete}</p>";

            // Afficher les images
            echo "<img src='{$carte['image_carte']}' alt='{$carte['nom']}' />";
            echo "</div>";
        }
    } else {
        echo "<p>Aucune carte n'a été trouvée.</p>";
    }
    ?>
</body>
</html>
