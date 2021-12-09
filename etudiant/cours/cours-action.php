<?php

    if(isset($_POST['btn_action'])){
        if($_POST['btn_action']=='consulter'){
            include("../control-if-user-is-connected.php");
            $query = "SELECT * FROM cours
            INNER JOIN classe ON id_classe_fk_cours=id_classe
            INNER JOIN matiere ON id_matiere_fk_cours=id_matiere
            INNER JOIN professeur ON id_professeur_fk_cours=id_professeur
            INNER JOIN personne ON id_personne_fk_professeur=id_personne
            WHERE del_cours='0' AND id_cours=?";

            $statement = $bdd->prepare($query);
            $statement->execute(array($_POST["id_view"]));
            $result = $statement->fetchAll();
            $output = '
            <div class="table-responsive">
                <table class="table">
            ';

            //$nom_professeur ='';

            foreach ($result as $row) {
                $output .= '
                <tr>
                    <td>Intitulé</td>
                    <td>'. $row['intitule_cours'] .'</td>
                </tr>
                <tr>
                    <td>Classe</td>
                    <td>' . $row["nom_classe"] . '</td>
                </tr>
                <tr>
                    <td>Matière</td>
                    <td>' . $row["nom_matiere"] . '</td>
                </tr>
                <tr>
                    <td>Date de début du cours</td>
                    <td>' . date("d-m-Y", strtotime($row["date_debut_cours"])) . ' à ' . date("H:i", strtotime($row["date_debut_cours"])) . '</td>
                </tr>';
                if($row["date_fin_cours"]!=NULL){
                    $output .= '<tr>
                                    <td>Date de fin du cours</td>
                                    <td>' . date("d-m-Y", strtotime($row["date_fin_cours"])) . ' à ' . date("H:i", strtotime($row["date_fin_cours"])) . '</td>
                                </tr>';
                }
                $output .= '<tr>
                    <td>Professeur</td>
                    <td>' . $row["prenom_personne"].' '. $row['nom_personne'] . '</td>
                </tr>
                <tr>
                    <td>Fichier 1</td>
                    <td><a href="../../img/fichiers/'.$row["fichier_1_cours"].'">' . $row["fichier_1_cours"] . '</a></td>
                </tr>
                <tr>
                    <td>Fichier 2</td>
                    <td><a href="../../img/fichiers/'.$row["fichier_2_cours"].'">' . $row["fichier_2_cours"] . '</a></td>
                </tr>
                <tr>
                    <td>Fichier 3</td>
                    <td><a href="../../img/fichiers/'.$row["fichier_3_cours"].'">' . $row["fichier_3_cours"] . '</a></td>
                </tr>
                <tr>
                    <td>Fichier 4</td>
                    <td><a href="../../img/fichiers/'.$row["fichier_4_cours"].'">' . $row["fichier_4_cours"] . '</a></td>
                </tr>
                <tr>
                    <td>Notes</td>
                    <td>' . $row["notes_cours"] . '</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>';
                if($row['statut_cours']=="Actif"){
                    $output .= "<span class='btn btn-pill btn-success mb-1'>".$row['statut_cours']."</span>";
                }
                else if($row['statut_cours']=="Inactif"){
                    $output .= "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_cours']."</span>";
                }
                $output .= '</td>
                </tr>
                <tr>
                    <td>Date de création</td>
                    <td>' . date("d-m-Y", strtotime($row["date_create_cours"])) . ' à ' . date("H:i", strtotime($row["date_create_cours"])) . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié le</td>
                    <td>' . date("d-m-Y", strtotime($row["date_last_modif_cours"])) . ' à ' . date("H:i", strtotime($row["date_last_modif_cours"])) . '</td>
                </tr>
                <tr>
                    <td>Enregistrée par</td>
                    <td>' . $row['user_create_cours'] . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié par</td>
                    <td>' . $row['user_create_cours'] . '</td>
                </tr>
                ';
            }


            $output .= '
                </table>
            </div>
            ';
            echo json_encode($output);
        }

        if($_POST['btn_action']=='activation'){
            include("../control-if-user-is-connected.php");
            update(" cours ",[
                "statut_cours" => "Actif"
            ]," id_cours = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM cours WHERE id_cours = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "Le cours ".$result['intitule_cours']." est désormais actif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='desactivation'){
            include("../control-if-user-is-connected.php");
            update(" cours ",[
                "statut_cours" => "Inactif"
            ]," id_cours = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM cours WHERE id_cours = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "Le cours ".$result['intitule_cours']." est désormais inactif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='delete'){
            include("../control-if-user-is-connected.php");
            $now = new DateTime();
            update(" cours ",[
                "del_cours" => 1,
                "date_del_cours" => $now->format('Y-m-d H:i:s'),
                "user_del_cours" => $_SESSION['nom']." ".$_SESSION['prenom']
            ]," id_cours = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM cours WHERE id_cours = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "Le cours ".$result['intitule_cours']." a été supprimée.";
            echo json_encode($output);
        }


        if($_POST['btn_action']=='telecharger'){
            include("../control-if-user-is-connected.php");
            $statement = $bdd->prepare("SELECT * FROM cours WHERE id_cours = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = [];
            if($result['fichier_1_cours'] != "")
                $output[] = $result['fichier_1_cours'];
            if($result['fichier_2_cours'] != "")
                $output[] = $result['fichier_2_cours'];
            if($result['fichier_3_cours'] != "")
                $output[] = $result['fichier_3_cours'];
            if($result['fichier_4_cours'] != "")
                $output[] = $result['fichier_4_cours'];
            echo json_encode($output);
        }
    }