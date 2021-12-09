<?php
    session_start();
    setcookie('email','',time()-3600);
    setcookie('mdp','',time()-3600);
    session_unset();
    header("Location:connexion.php");
?>