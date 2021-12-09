<?php
    if(isset($_POST['btn_action'])){
        if($_POST['btn_action']=='consulter'){
            include("../control-if-user-is-connected.php");
            $query = "SELECT id_signale, statut_signale, nom_classe, personne_etudiant.nom_personne AS nom_etudiant, personne_etudiant.prenom_personne AS prenom_etudiant, personne_professeur.nom_personne AS nom_professeur, personne_professeur.prenom_personne AS prenom_professeur, date_create_signale, date_last_modif_signale, user_create_signale, user_create_signale, motif_signale FROM signale
            INNER JOIN etudiant ON id_etudiant_fk_signale=id_etudiant
            INNER JOIN personne AS personne_etudiant ON id_personne_fk_etudiant=personne_etudiant.id_personne
            INNER JOIN classe ON id_classe_fk_etudiant=id_classe
            INNER JOIN professeur ON id_professeur_fk_signale=id_professeur
            INNER JOIN personne AS personne_professeur ON id_personne_fk_professeur=personne_professeur.id_personne
            WHERE del_signale = '0' AND id_signale = ?";

            $statement = $bdd->prepare($query);
            $statement->execute(array($_POST["id_view"]));
            $result = $statement->fetchAll();
            $output = '
            <div class="table-responsive">
                <table class="table">
            ';

            foreach ($result as $row) {
                $output .= '
                <tr>
                    <td>Etudiant</td>
                    <td>' . $row["nom_etudiant"].' '. $row['prenom_etudiant'] . '</td>
                </tr>
                <tr>
                    <td>Classe</td>
                    <td>' . $row["nom_classe"] . '</td>
                </tr>
                <tr>
                    <td>Professeur</td>
                    <td>' . $row["nom_professeur"].' '. $row['prenom_professeur'] . '</td>
                </tr>
                <tr>
                    <td>Motif</td>
                    <td>' . $row["motif_signale"] . '</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>';
                if($row['statut_signale']=="Lu"){
                    $output .= "<span class='btn btn-pill btn-success mb-1'>".$row['statut_signale']."</span>";
                }
                else if($row['statut_signale']=="Non lu"){
                    $output .= "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_signale']."</span>";
                }
                $output .= '</td>
                </tr>
                <tr>
                    <td>Date de création</td>
                    <td>' . date("d-m-Y", strtotime($row["date_create_signale"])) . ' à ' . date("H:i", strtotime($row["date_create_signale"])) . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié le</td>
                    <td>' . date("d-m-Y", strtotime($row["date_last_modif_signale"])) . ' à ' . date("H:i", strtotime($row["date_last_modif_signale"])) . '</td>
                </tr>
                <tr>
                    <td>Enregistrée par</td>
                    <td>' . $row['user_create_signale'] . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié par</td>
                    <td>' . $row['user_create_signale'] . '</td>
                </tr>
                ';
            }

            $output .= '
                </table>
            </div>
            ';
            echo json_encode($output);
        }

        if($_POST['btn_action']=='masquer_comme_lu'){
            include("../control-if-user-is-connected.php");
            update(" signale ",[
                "statut_signale" => "Lu"
            ]," id_signale = '".$_POST['id']."'");
            $output = "Le signal a été masqué comme lu.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='masquer_non_comme_lu'){
            include("../control-if-user-is-connected.php");
            update(" signale ",[
                "statut_signale" => "Non lu"
            ]," id_signale = '".$_POST['id']."'");
            $output = "Le signal a été masqué comme non lu.";
            echo json_encode($output);
        }
    }