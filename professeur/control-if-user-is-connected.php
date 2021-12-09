<?php
    include("../../others/db.php");
    include("../../others/fonctions.php");
    include("../../others/fonctions-sql.php");
    session_start();
    if(isset($_SESSION["id"])){
        if($_SESSION['id_type_compte']==2){
            
        }
        else{
            header("Location:../../index.php");
        }
    }
    else if(isset($_COOKIE['email'],$_COOKIE['mdp']) AND !empty($_COOKIE['email']) AND !empty($_COOKIE['mdp'])){
        $statement = $bdd->prepare("SELECT * FROM compte INNER JOIN personne ON compte.id_personne_fk_compte = personne.id_personne WHERE del_personne='0' AND email_personne = :email");
        $statement->execute(array(':email'	=>	$_COOKIE['email']));
        if($statement->rowCount() > 0){
            $mdp_correct = false;
            while($row = $statement->fetch()){
                if($_COOKIE['mdp'] == $row["mdp_compte"]){
                    if($row["statut_compte"] == "Actif"){
                        $_SESSION['id'] = $row['id_personne'];
                        $_SESSION["nom"] = $row["nom_personne"];
                        $_SESSION["prenom"] = $row["prenom_personne"];
                        $_SESSION["email"] = $row["email_personne"];
                        $_SESSION["id_type_compte"] = $row["id_type_compte_fk_compte"];
                        $_SESSION["photo"] = $row["photo_personne"];
                        //$_SESSION["menu"] = get_menu_by_compte($row['id_compte']);
                    }
                    else{
                        ?>
                        <script>swal("Échoué","Votre compte est Inatif veuillez contacter l'administrateur.","error") </script>
                        <?php
                    }
                    $mdp_correct = true;
                }
            }
            if($mdp_correct == false){
                header("Location:../../others/connexion.php");
            }
        }
        else{
            header("Location:../../others/connexion.php");
        }
    }
    else{
        header("Location:../../others/connexion.php");
    }
?>