<?php

    if(isset($_POST['btn_action'])){
        if($_POST['btn_action']=='consulter'){
            include("../control-if-user-is-connected.php");
            $query = "SELECT * FROM etudiant
            INNER JOIN personne ON id_personne_fk_etudiant=id_personne
            INNER JOIN classe ON id_classe_fk_etudiant=id_classe
            WHERE del_personne='0' AND id_etudiant = ?";

            $statement = $bdd->prepare($query);
            $statement->execute(array($_POST["id_view"]));
            $result = $statement->fetchAll();
            $output = '
            <div class="table-responsive">
                <table class="table">
            ';

            //$nom_etudiant ='';

            foreach ($result as $row) {
                $output .= '
                <tr>
                    <td>Photo</td>
                    <td>
                        <div style="width: 80px; height: 80px; overflow: hidden; border-radius: 50%;">
                            <img style="height: 100%; margin: auto;" src="../../img/personnes/'.$row['photo_personne'].'">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Matricule</td>
                    <td>' . $row["matricule_etudiant"] . '</td>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td>' . $row["nom_personne"] . '</td>
                </tr>
                <tr>
                    <td>Prénom</td>
                    <td>' . $row["prenom_personne"] . '</td>
                </tr>
                <tr>
                    <td>Téléphone</td>
                    <td>' . $row["tel_personne"] . '</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>' . $row["email_personne"] . '</td>
                </tr>
                <tr>
                    <td>Sexe</td>
                    <td>' . $row["sexe_personne"] . '</td>
                </tr>
                <tr>
                    <td>Classe</td>
                    <td>' . $row["nom_classe"] . '</td>
                </tr>
                <tr>
                    <td>Notes</td>
                    <td>' . $row["notes_etudiant"] . '</td>
                </tr>
                <tr>
                    <td>Date de naissance</td>
                    <td>' . $row["date_naissance_personne"] . '</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>';
                if($row['statut_personne']=="Actif"){
                    $output .= "<span class='btn btn-pill btn-success mb-1'>".$row['statut_personne']."</span>";
                }
                else if($row['statut_personne']=="Inactif"){
                    $output .= "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_personne']."</span>";
                }
                $output .= '</td>
                </tr>
                <tr>
                    <td>Date de création</td>
                    <td>' . date("d-m-Y", strtotime($row["date_create_personne"])) . ' à ' . date("H:i", strtotime($row["date_create_personne"])) . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié le</td>
                    <td>' . date("d-m-Y", strtotime($row["date_last_modif_personne"])) . ' à ' . date("H:i", strtotime($row["date_last_modif_personne"])) . '</td>
                </tr>
                <tr>
                    <td>Enregistrée par</td>
                    <td>' . $row['user_create_personne'] . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié par</td>
                    <td>' . $row['user_create_personne'] . '</td>
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
            update(" etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne ",[
                "statut_personne" => "Actif"
            ]," id_etudiant = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne WHERE id_etudiant = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La etudiant ".$result['prenom_personne']. " " .$result['nom_personne']." est désormais actif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='desactivation'){
            include("../control-if-user-is-connected.php");
            update(" etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne ",[
                "statut_personne" => "Inactif"
            ]," id_etudiant = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne WHERE id_etudiant = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La etudiant ".$result['prenom_personne']. " " .$result['nom_personne']." est désormais inactif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='delete'){
            include("../control-if-user-is-connected.php");
            $now = new DateTime();
            update(" etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne ",[
                "del_personne" => 1,
                "date_del_personne" => $now->format('Y-m-d H:i:s'),
                "user_del_personne" => $_SESSION['nom']." ".$_SESSION['prenom']
            ]," id_etudiant = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne WHERE id_etudiant = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La etudiant ".$result['prenom_personne']. " " .$result['nom_personne']." a été supprimée.";
            echo json_encode($output);
        }
    }