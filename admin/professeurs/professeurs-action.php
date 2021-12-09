<?php

    if(isset($_POST['btn_action'])){
        if($_POST['btn_action']=='consulter'){
            include("../control-if-user-is-connected.php");
            $query = "SELECT * FROM professeur
            INNER JOIN personne ON id_personne_fk_professeur=id_personne
            INNER JOIN matiere ON id_matiere_fk_professeur=id_matiere
            WHERE del_personne='0' AND id_professeur = ?";

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
                    <td>Photo</td>
                    <td>
                        <div style="width: 80px; height: 80px; overflow: hidden; border-radius: 50%;">
                            <img style="height: 100%; margin: auto;" src="../../img/personnes/'.$row['photo_personne'].'">
                        </div>
                    </td>
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
                    <td>Matière</td>
                    <td>' . $row["nom_matiere"] . '</td>
                </tr>
                <tr>
                    <td>Notes</td>
                    <td>' . $row["notes_professeur"] . '</td>
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
            update(" professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne ",[
                "statut_personne" => "Actif"
            ]," id_professeur = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE id_professeur = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La professeur ".$result['prenom_personne']. " " .$result['nom_personne']." est désormais actif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='desactivation'){
            include("../control-if-user-is-connected.php");
            update(" professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne ",[
                "statut_personne" => "Inactif"
            ]," id_professeur = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE id_professeur = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La professeur ".$result['prenom_personne']. " " .$result['nom_personne']." est désormais inactif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='delete'){
            include("../control-if-user-is-connected.php");
            $now = new DateTime();
            update(" professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne ",[
                "del_personne" => 1,
                "date_del_personne" => $now->format('Y-m-d H:i:s'),
                "user_del_personne" => $_SESSION['nom']." ".$_SESSION['prenom']
            ]," id_professeur = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE id_professeur = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La professeur ".$result['prenom_personne']. " " .$result['nom_personne']." a été supprimée.";
            echo json_encode($output);
        }
    }