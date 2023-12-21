<link rel="stylesheet" href="Carte.css">
<?php
include "VerrificationsRole.php";
// Inclure le fichier de connexion à la base de données
include "connexionBDD.php";
if (isset($_POST['submit_supprimer'])) {
    $id_carte = $_POST['id_carte'];
    $requete =$connexion->prepare("DELETE FROM carte WHERE id = ?;");
    $requete->execute([$id_carte]);
}
if (isset($_POST['Ajout_deck'])) {
    $id_carte = $_POST['id_carte'];
    $requete= $connexion->query("SELECT id,identifiant FROM user");
    $personnes= $requete->fetchAll();
    foreach($personnes as $personne){
        if(password_verify( $_COOKIE["pseudo"],$personne["identifiant"])){
            $requete= $connexion->prepare("INSERT INTO deck (id_carte, id_user) VALUES (?, ?);");
            $requete->execute([$id_carte,$personne["id"]]);
        }
    }
}

// Récupérer les filtres depuis le formulaire
$terme_Recherche = isset($_GET['termeRecherche']) ? $_GET['termeRecherche'] : '';
$typeFiltre = isset($_GET['typeFiltre']) ? $_GET['typeFiltre'] : 'nom';
$ordre_de_Tri = isset($_GET['ordre_de_Tri']) ? $_GET['ordre_de_Tri'] : 'asc';

// Construire la requête SQL de base
$sql = "SELECT * FROM carte";

// Ajouter les filtres à la requête SQL
if (!empty($terme_Recherche)) {
    $sql .= " WHERE nom LIKE '%$terme_Recherche%'";
}

// on ajoute une requête SQL pour faire le tri par nom ou par prix ou par type
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
    <link rel="stylesheet" href="Carte.css">
    <title>Liste des Cartes</title>
</head>
<body>
    <div class = "carte">
    <div class = "retour">
    <?php
        include "deconexion.php";
    ?>
    <a href="Connecte.php" class="button">Retour au menu</a>
    </div>

    <h1 class = "h1">Liste des Cartes</h1>

    <!-- c'est un formulaire de filtres -->
    <form method="get" action="">
        <div class = "recherche">
        <label for="termeRecherche">Rechercher par nom :</label>
        <input type="text" name="termeRecherche" value="<?= $terme_Recherche ?>">
        </div>

        <label for="typeFiltre">Trier par :</label>
        <select name="typeFiltre">
            <option value="nom" <?= $typeFiltre == 'nom' ? 'selected' : '' ?>>Nom</option>
            <option value="prix" <?= $typeFiltre == 'prix' ? 'selected' : '' ?>>Prix</option>
            <option value="type" <?= $typeFiltre == 'type' ? 'selected' : '' ?>>Type</option>
        </select>

        <label for="ordre_de_Tri">Ordre :</label>
        <select name="ordre_de_Tri">
            <option value="asc" <?= $ordre_de_Tri == 'asc' ? 'selected' : '' ?>>Croissant</option>
            <option value="desc" <?= $ordre_de_Tri == 'desc' ? 'selected' : '' ?>>Décroissant</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <?php
    // Affichage des cartes filtrées et triées
    if (count($cartes) > 0) {
        foreach ($cartes as $carte) {
            // Afficher les détails de chaque carte
            echo "<div>";
            echo "<div class='detail-carte'>";
            echo "<div class='contenu-cadre'>";
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
            echo "</div>";
            echo "</div>";

            // Affichage des images
            echo "<img src='{$carte['image_carte']}' alt='{$carte['nom']}' />";

            // Ajout de la carte dans le deck du joueur
            $id = $carte["id"];
            echo("<form method='post' action='Carte.php'>");
            echo("<input type='hidden' name='id_carte' value='$id'>");
            echo("<button type='submit' name='Ajout_deck'>Ajouter</button>");
            echo("</form>");

            // Si connecté en administrateur permet de supprimer la carte de la BDD
            if($_COOKIE["rang"]=="administrateur"){
                echo("<form method='post' action='Carte.php'>");
                echo("<input type='hidden' name='id_carte' value='$id'>");
                echo("<button type='submit' name='submit_supprimer'>Supprimer</button>");
                echo("</form>");
            }
            echo "</div>";
        }
    } else {
        echo "<p>Aucune carte n'a été trouvée.</p>";
    }
    ?>
    </div>
</body>
</html>
