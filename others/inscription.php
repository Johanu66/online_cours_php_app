<?php
    include("db.php");
    include("fonctions.php");
    include("fonctions-sql.php");
    if(isset($_POST['submit'])){
        $alert_text = "fghjk";
        if(!empty($_POST['matricule']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['sexe']) && !empty($_POST['classe']) && !empty($_POST['tel']) && !empty($_POST['date']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])){
            $password = htmlspecialchars($_POST['password']);
            $password_confirm = htmlspecialchars($_POST['password_confirm']);
            if($password == $password_confirm){
                $email = htmlspecialchars($_POST['email']);
                $statement = $bdd->prepare("SELECT * FROM personne WHERE del_personne='0' AND email_personne = ?");
                $statement->execute(array($email));
                if($statement->rowCount() < 1){
                    $photo = "default.jpg";
                    // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                    if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
                    {
                        // Testons si le fichier n'est pas trop gros
                        if ($_FILES['photo']['size'] <= 1000000000)
                        {
                            // Testons si l'extension est autorisée
                            $infosfichier = pathinfo($_FILES['photo']['name']);
                            $extension_upload = $infosfichier['extension'];
                            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                            if (in_array($extension_upload, $extensions_autorisees))
                            {
                                // On peut valider le fichier et le stocker définitivement
                                $photo = htmlspecialchars(basename($_FILES['photo']['name']));
                                move_uploaded_file($_FILES['photo']['tmp_name'], "../img/personnes/".$photo);
                                
                            }
                            else{
                                $alert_text = "Extension de la photo de profil n'est acceptable.";
                            }
                        }
                        else{
                            $alert_text = "La photo de profil est trop volumineux.";
                        }            
                    }
                    $matricule = htmlspecialchars($_POST['matricule']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $sexe = htmlspecialchars($_POST['sexe']);
                    $classe = htmlspecialchars($_POST['classe']);
                    $tel = htmlspecialchars($_POST['tel']);
                    $date = htmlspecialchars($_POST['date']);
                    $notes = htmlspecialchars($_POST['notes']);
                    $now = new DateTime();
                    insert("personne",[
                        "nom_personne" => $nom,
                        "prenom_personne" => $prenom,
                        "email_personne" => $email,
                        "tel_personne" => $tel,
                        "sexe_personne" => $sexe,
                        "statut_personne" => 'En attente',
                        "date_naissance_personne" => $date,
                        "photo_personne" => $photo,
                        "date_create_personne" => $now->format('Y-m-d H:i:s'),
                        "date_last_modif_personne" => $now->format('Y-m-d H:i:s')
                    ]);
                    $statement = $bdd->query("SELECT MAX(id_personne) as last_id_personne FROM personne");
                    $row = $statement->fetch();
                    insert("etudiant",[
                        "matricule_etudiant" => $matricule,
                        "notes_etudiant" => $notes,
                        "id_personne_fk_etudiant" => $row['last_id_personne'],
                        "id_classe_fk_etudiant" => $classe
                    ]);
                    insert("compte",[
                        "mdp_compte" => $password,
                        "date_create_compte" => $now->format('Y-m-d H:i:s'),
                        "date_last_modif_compte" => $now->format('Y-m-d H:i:s'),
                        "id_personne_fk_compte" => $row['last_id_personne'],
                        "id_type_compte_fk_compte" => 3
                    ]);
                    setcookie("success","Votre compte a été créé, vous aurez accès à votre compte dès qu'elle sera validé.",time()+(86400*30),"/");
                    header('Location:connexion.php');
                }
                else{
                    $alert_text = "Cet email existe déjà.";
                }
            }
            else{
                $alert_text = "Mots de passe non identites.";
            }
        }
        else{
            $alert_text = "Veuillez renseigner tous les chmaps.";
        }
    }
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Register | Kiaalap - Kiaalap Admin Template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon
        ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.ico">
        <!-- Google Fonts
        ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Bootstrap CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <!-- owl.carousel CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.theme.css">
        <link rel="stylesheet" href="../css/owl.transitions.css">
        <!-- animate CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/animate.css">
        <!-- normalize CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/normalize.css">
        <!-- meanmenu icon CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/meanmenu.min.css">
        <!-- main CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/main.css">
        <!-- educate icon CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/educate-custon-icon.css">
        <!-- morrisjs CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/morrisjs/morris.css">
        <!-- mCustomScrollbar CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- metisMenu CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/metisMenu/metisMenu.min.css">
        <link rel="stylesheet" href="../css/metisMenu/metisMenu-vertical.css">
        <!-- calendar CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/calendar/fullcalendar.min.css">
        <link rel="stylesheet" href="../css/calendar/fullcalendar.print.min.css">
        <!-- x-editor CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/editor/select2.css">
        <link rel="stylesheet" href="../css/editor/datetimepicker.css">
        <link rel="stylesheet" href="../css/editor/bootstrap-editable.css">
        <link rel="stylesheet" href="../css/editor/x-editor-style.css">
        <!-- normalize CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <!-- forms CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/form/all-type-forms.css">
        <!-- style CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/style.css">
        <!-- responsive CSS
        ============================================ -->
        <link rel="stylesheet" href="../css/responsive.css">
        <!-- modernizr JS
        ============================================ -->
        <script src="../js/vendor/modernizr-2.8.3.min.js"></script>

        <!-- Sweet Alert
        ============================================ -->
        <script src="../js/sweetalert/sweetalert.min.js"></script>
    </head>

    <body>
        <?php
            if(isset($alert_text)){
                ?>
                <script>
                    swal("Échoué", "<?php echo $alert_text ?>", "error")
                </script>
                <?php
            }
        ?>
        <div class="error-pagewrap">
            <div class="error-page-int">
                <div class="text-center custom-login">
                    <h3>Inscription</h3>
                    <p>C'est la meilleure application qui soit !</p>
                </div>
                <div class="content-error">
                    <div class="hpanel">
                        <div class="panel-body">
                            <form action="" method="POST" enctype="multipart/form-data" id="loginForm">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="matricule">Matricule</label>
                                            <input type="text" name="matricule" class="form-control" id="matricule" value="<?php if(isset($_POST['matricule'])){ echo($_POST['matricule']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" name="nom" class="form-control" id="nom" value="<?php if(isset($_POST['nom'])){ echo($_POST['nom']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="prenom">Prénom</label>
                                            <input type="text" name="prenom" class="form-control" id="prenom" value="<?php if(isset($_POST['prenom'])){ echo($_POST['prenom']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="sexe">Sexe</label>
                                            <select name="sexe" id="sexe" class="form-control">
                                                <option value="">---</option>
                                                <option value="M" <?php if(isset($_POST['sexe']) && $_POST['sexe']=='M'){ echo('selected'); } ?>>Masculin</option>
                                                <option value="F" <?php if(isset($_POST['sexe']) && $_POST['sexe']=='F'){ echo('selected'); } ?>>Féminin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date de naissance</label>
                                            <input type="date" name="date" class="form-control" id="date" value="<?php if(isset($_POST['date'])){ echo($_POST['date']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="tel">Téléphone</label>
                                            <input type="text" name="tel" class="form-control" id="tel" value="<?php if(isset($_POST['tel'])){ echo($_POST['tel']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" value="<?php if(isset($_POST['email'])){ echo($_POST['email']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="password">Mot de passe</label>
                                            <input type="password" name="password" class="form-control" id="password" value="<?php if(isset($_POST['password'])){ echo($_POST['password']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirm">Ressaisir le mot de passe</label>
                                            <input type="password" name="password_confirm" class="form-control" id="password_confirm" value="<?php if(isset($_POST['password_confirm'])){ echo($_POST['password_confirm']); } ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="classe">Classe</label>
                                            <select name="classe" id="classe" class="form-control">
                                                <option value="">---</option>
                                                <?php
                                                    if(isset($_POST['classe'])){
                                                        echo(charger_classe($_POST['classe']));
                                                    }else{
                                                        echo(charger_classe(null));
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="photo">Photo de profil</label>
                                            <input type="file" name="photo" class="form-control" id="photo">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input class="btn btn-success loginbtn" type="submit" name="submit" value="S'inscrire">
                                    <a href="connexion.php" class="btn btn-default" style="padding-left: 10px; padding-right: 10px;">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center login-footer">
                    <p>Copyright © 2021. Tous droits réservés. Créer par Johanu</p>
                </div>
            </div>   
        </div>
        <!-- jquery
        ============================================ -->
        <script src="../js/vendor/jquery-1.12.4.min.js"></script>
        <!-- bootstrap JS
        ============================================ -->
        <script src="../js/bootstrap.min.js"></script>
        <!-- wow JS
        ============================================ -->
        <script src="../js/wow.min.js"></script>
        <!-- price-slider JS
        ============================================ -->
        <script src="../js/jquery-price-slider.js"></script>
        <!-- meanmenu JS
        ============================================ -->
        <script src="../js/jquery.meanmenu.js"></script>
        <!-- owl.carousel JS
        ============================================ -->
        <script src="../js/owl.carousel.min.js"></script>
        <!-- sticky JS
        ============================================ -->
        <script src="../js/jquery.sticky.js"></script>
        <!-- scrollUp JS
        ============================================ -->
        <script src="../js/jquery.scrollUp.min.js"></script>
        <!-- counterup JS
        ============================================ -->
        <script src="../js/counterup/jquery.counterup.min.js"></script>
        <script src="../js/counterup/waypoints.min.js"></script>
        <script src="../js/counterup/counterup-active.js"></script>
        <!-- mCustomScrollbar JS
        ============================================ -->
        <script src="../js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="../js/scrollbar/mCustomScrollbar-active.js"></script>
        <!-- metisMenu JS
        ============================================ -->
        <script src="../js/metisMenu/metisMenu.min.js"></script>
        <script src="../js/metisMenu/metisMenu-active.js"></script>
        <!-- data table JS
        ============================================ -->
        <script src="../js/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../js/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../js/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../js/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!--  editable JS
        ============================================ -->
        <script src="../js/editable/jquery.mockjax.js"></script>
        <script src="../js/editable/mock-active.js"></script>
        <script src="../js/editable/select2.js"></script>
        <script src="../js/editable/moment.min.js"></script>
        <script src="../js/editable/bootstrap-datetimepicker.js"></script>
        <script src="../js/editable/bootstrap-editable.js"></script>
        <script src="../js/editable/xediable-active.js"></script>
        <!-- Chart JS
        ============================================ -->
        <script src="../js/chart/jquery.peity.min.js"></script>
        <script src="../js/peity/peity-active.js"></script>
        <!-- tab JS
        ============================================ -->
        <script src="../js/tab.js"></script>
        <!-- icheck JS
        ============================================ -->
        <!-- <script src="../js/icheck/icheck.min.js"></script>
        <script src="../js/icheck/icheck-active.js"></script> -->
        <!-- morrisjs JS
        ============================================ -->
        <script src="../js/morrisjs/raphael-min.js"></script>
        <script src="../js/morrisjs/morris.js"></script>
        <script src="../js/morrisjs/morris-active.js"></script>
        <!-- morrisjs JS
        ============================================ -->
        <script src="../js/sparkline/jquery.sparkline.min.js"></script>
        <script src="../js/sparkline/jquery.charts-sparkline.js"></script>
        <script src="../js/sparkline/sparkline-active.js"></script>
        <!-- calendar JS
        ============================================ -->
        <script src="../js/calendar/moment.min.js"></script>
        <script src="../js/calendar/fullcalendar.min.js"></script>
        <script src="../js/calendar/fullcalendar-active.js"></script>
        <!-- plugins JS
        ============================================ -->
        <script src="../js/plugins.js"></script>
        <!-- main JS
        ============================================ -->
        <script src="../js/main.js"></script>
        <!-- tawk chat JS
        ============================================ -->
        <script src="../js/tawk-chat.js"></script>
        <!-- JS Libraies
        ============================================ -->
    </body>
</html>