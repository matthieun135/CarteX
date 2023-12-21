<form method="post">
        <input type="submit" name="deconnexion" classname="deconnexion"
        class="deconnexion" value="deconnexion" />
</form>
<style>
    .deconnexion {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        margin-top: 10px;
        margin-bottom: 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }
</style>
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
