<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        ><link rel="stylesheet" href="connexion.css">
        <title>Connexion</title>
    </head>
    <body>
=======
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <title>Connexion</title>
</head>
<body>
>>>>>>> 54946ae182a2105dbb3cea52ed606b3c9a328a04
    <a href="Accueil.html"><button class="bouton" id="btn-Accueil">Accueil</button></a>
    <h2>Bienvenue sur la page Connexion</h2>
    <form method="post" action="connexion.php"> 
    <?php
    unset($_COOKIE["rang"]);
    if (isset($_POST["pseudo"])){
        include("connexionBDD.php");
        $requete = $connexion->query("SELECT * FROM user");
        $utilisateur= $requete->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0; $i < sizeof($utilisateur); $i++) { 
            if (password_verify($_POST["pseudo"], $utilisateur[$i]["identifiant"]) 
            && password_verify($_POST["mot_de_passe"], $utilisateur[$i]["pwd"])){
                $rang= $utilisateur[$i]["rang"];
                setcookie("rang", $rang);
                header("Location: Carte.php");
                exit;
            }
        }
<<<<<<< HEAD
        echo("<h3>*Pseudo ou mots de passe incorect!</h3>");
=======
        echo("<h3>*Pseudo ou mot de passe incorect!</h3>");
>>>>>>> 54946ae182a2105dbb3cea52ed606b3c9a328a04
    }
    ?>
    <label for="pseudo">Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" required><br>
    <label for="mot_de_passe" required>Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>
    <input type="submit" value="Valider">
</form>
</body>
</html>
