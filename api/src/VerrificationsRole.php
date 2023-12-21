<?php
if (!isset($_COOKIE["rang"]) && ( !$_COOKIE["rang"]=="utilisateur" || !$_COOKIE["rang"]=="administrateur")){
    header("Location: Accueil.html");
}
?>