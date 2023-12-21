<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inscription.css">
    <title>Inscription</title>
</head>
<body>
    <a href="Accueil.html"><button class="bouton" id="btn-Accueil">Accueil</button></a>
    <h2>Bienvenue sur la page Inscription</h2>
    <?php
    if (isset($_POST["pseudo"])){
        unset($_COOKIE["role"]);
        $exist=FALSE;
        include("connexionBDD.php");
        $requete = $connexion->query("SELECT * FROM user");
        $utilisateur= $requete->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0; $i < sizeof($utilisateur); $i++) { 
            if (password_verify($_POST["pseudo"], $utilisateur[$i]["identifiant"]) 
            || password_verify($_POST["mot_de_passe"], $utilisateur[$i]["pwd"])){
                $exist=True;
                break;
            }
        }
        if(!$exist){
            $requete= $connexion->prepare("INSERT INTO user (identifiant,pwd,rang)  VALUES (?,?,?)");
            $identifiant=password_hash($_POST["pseudo"], PASSWORD_DEFAULT);
            $pwd=password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);
            $rang="utilisateur";
            $requete->execute([$identifiant,$pwd,$rang]);
            $pseudo= $_POST["pseudo"];
            setcookie("rang", "utilisateur");
            setcookie("pseudo",$pseudo);
            header("Location: Carte.php");
        }
    }
    ?>
<form method="post" action="inscription.php">
    <label for="pseudo">Pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" required><br>
    <label for="mot_de_passe" required>Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required><br>
    <input type="submit" value="Valider">
</form>
</body>
</html>