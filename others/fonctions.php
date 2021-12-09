<?php

    function charger_classe($id){
        include("db.php");
        $classes = "";
        $statement2 = $bdd->query("SELECT * FROM classe WHERE del_classe='0'");
        while($row = $statement2->fetch()){
            $classes .= "<option value='".$row['id_classe']."'";
            if($row['id_classe'] == $id){
                $classes .= " selected ";
            }
            $classes .= ">".$row['nom_classe']."</option>";
        }
        return $classes;
    }

    function charger_matiere($id){
        include("db.php");
        $matieres = "";
        $statement2 = $bdd->query("SELECT * FROM matiere WHERE del_matiere='0'");
        while($row = $statement2->fetch()){
            $matieres .= "<option value='".$row['id_matiere']."'";
            if($row['id_matiere'] == $id){
                $matieres .= " selected ";
            }
            $matieres .= ">".$row['nom_matiere']."</option>";
        }
        return $matieres;
    }

    function charger_professeur($id){
        include("db.php");
        $professeurs = "";
        $statement2 = $bdd->query("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE del_personne='0'");
        while($row = $statement2->fetch()){
            $professeurs .= "<option value='".$row['id_professeur']."'";
            if($row['id_professeur'] == $id){
                $professeurs .= " selected ";
            }
            $professeurs .= ">".$row['prenom_personne']." ".$row['nom_personne']."</option>";
        }
        return $professeurs;
    }

    function get_id_prof_by_id_personne($id){
        include("db.php");
        $statement2 = $bdd->prepare("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE id_personne=?");
        $statement2->execute(array($id));
        $row = $statement2->fetch();
        return $row['id_professeur'];
    }

    
    function get_student_class_id($id){
        include("db.php");
        $statement2 = $bdd->prepare("SELECT * FROM etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne WHERE id_personne=?");
        $statement2->execute(array($id));
        $row = $statement2->fetch();
        return $row['id_classe_fk_etudiant'];
    }

    function get_total($tab,$condition){
        include("db.php");
        $statement2 = $bdd->query("SELECT * FROM ".$tab." WHERE ".$condition);
        return $statement2->rowCount();
    }

?>