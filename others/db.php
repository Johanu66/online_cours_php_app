<?php
    //Connexion à la bd
    try{
        $bdd = new PDO("mysql:host=localhost;dbname=cours_en_ligne;charset=utf8","root","", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
