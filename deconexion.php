<form method="post">
        <input type="submit" name="deconnexion"
                class="deconnexion" value="deconnexion" />
</form>
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