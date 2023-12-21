<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Connecte.css">
    <title>Bienvenue!</title>
</head>
<body>
    <?php
        include "deconexion.php";
        include "VerrificationsRole.php";
    ?>
    <div id="welcomeMessage">
        <h1>Bonjour, 
            <?php
                echo(" ".$_COOKIE["pseudo"]);
            ?>
            !</h1>

    </div>

    <div class="container" id="userActions">
        <a href="Carte.php" class="bouton">Bibliothèque de Cartes</a>
        <a href="mon_deck.php" class="bouton">Mon Deck</a>
    </div>

</body>
</html>