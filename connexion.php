<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <title>Connexion</title>
</head>
<body>
    <a href="Accueil.html"><button class="bouton" id="btn-Accueil">Accueil</button></a>
    <h2>Bienvenue sur la page Connexion</h2>
    <form method="post" action="connexion.php"> 
    <?php
    if (isset($_POST["pseudo"])){
        include("connexionBDD.php");
        $requete = $connexion->query("SELECT * FROM user");
        $utilisateur= $requete->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0; $i < sizeof($utilisateur); $i++) { 
            if (password_verify($_POST["pseudo"], $utilisateur[$i]["identifiant"]) 
            && password_verify($_POST["mot_de_passe"], $utilisateur[$i]["pwd"])){
                $rang= $utilisateur[$i]["rang"];
                $pseudo= $_POST["pseudo"];
                setcookie("rang", $rang);
                setcookie("pseudo",$pseudo);
                header("Location: Carte.php");
                exit;
            }
        }
        echo("<h3>*Pseudo ou mot de passe incorect!</h3>");
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
