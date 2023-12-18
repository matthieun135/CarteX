<?php
include "config.php";
try {
    $hote = $DB_hote;
    $utilisateur = $DB_utilisateur;
    $motDePasse = $DB_motDePasse;
    $nomDeLaBase = $DB_nomDeLaBase;
    //connection avcec la base de donnée
    $connexion = new PDO("mysql:host=$hote;dbname=$nomDeLaBase", $utilisateur, $motDePasse);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si il y a une erreur de connexion, affiche le message d'erreur et arrete le script
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    die();
}

?>