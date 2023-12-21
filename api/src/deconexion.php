<link rel="stylesheet" href="deconnexion.css">
<div >
<form method="post">
        <input type="submit" name="deconnexion" class = "bouton" value="deconnexion" />
</form>
</div>
<?php
function deconnexion(){
    unset($_COOKIE["rang"]);
    setcookie("rang", "");
    header("Location: Accueil.html");
}
if(array_key_exists('deconnexion', $_POST)) {
    deconnexion();
}

?>