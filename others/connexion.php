<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Connexion | O-Class</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("header-inclusion-for-connexion.php"); ?>
    </head>
    <body style="background-image: url('../img/bg.jpg');background-position: center;background-size: cover;">
        <?php
            include("db.php");
            include("fonctions-sql.php");
            $mdp_correct = false;
            if(isset($_POST["submit"])){
                $statement = $bdd->prepare("SELECT * FROM compte INNER JOIN personne ON compte.id_personne_fk_compte = personne.id_personne WHERE del_personne='0' AND email_personne = :email");
                $statement->execute(array(':email'	=>	$_POST["email"]));
                if($statement->rowCount() > 0){
                    while($row = $statement->fetch()){
                        if($_POST["mdp_compte"] == $row["mdp_compte"]){
                            if($row["statut_personne"] == "Actif"){
                                if(isset($_POST['remenber_me'])){
                                    setcookie('email',$row["email_personne"],time()+365*24*3600,null,null,false,true);
                                    setcookie('mdp',$row["mdp_compte"],time()+365*24*3600,null,null,false,true);
                                }
                                session_start();
                                $_SESSION['id'] = $row['id_personne'];
                                $_SESSION["nom"] = $row["nom_personne"];
                                $_SESSION["prenom"] = $row["prenom_personne"];
                                $_SESSION["email"] = $row["email_personne"];
                                $_SESSION["tel"] = $row["tel_personne"];
                                $_SESSION["id_type_compte"] = $row["id_type_compte_fk_compte"];
                                $_SESSION["photo"] = $row["photo_personne"];
                                header("Location:../index.php");
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
                        ?>
                        <script>swal("Échoué","Identifiant ou mot de passe incorrect.","error") </script>
                        <?php
                    }
                }
                else{
                    ?>
                    <script>swal("Échoué","Identifiant ou mot de passe incorrect.","error") </script>
                    <?php
                }
            }
            if(isset($_COOKIE['success'])){
                ?>
                <script>swal("Effectué", "<?php echo $_COOKIE['success']; ?>", "success")</script>
                <?php
                setcookie("success","",-1,"/");
            }
        ?>
        <div class="error-pagewrap" style="background-color: rgba(0,0,0,0.3);">
            <div class="error-page-int">
                <div class="text-center m-b-md custom-login">
                    <h3>CONNEXION</h3>
                    <p>Ceci est une version de test avec des identifiants de visiteur.<br>L'application originale est privée et interne à O-CLASS</p>
                </div>
                <div class="content-error">
                    <div class="hpanel">
                        <div class="panel-body">
                            <form action="" id="loginForm" method="POST">
                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" placeholder="example@gmail.com" title="Please enter you username" required value="<?php if(isset($_POST['email'])){ echo($_POST['email']); } else{ echo "alice.leroy@example.com"; } ?>" name="email" id="email" class="form-control">
                                    <span class="help-block small">Votre unique email pour l'application</span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="mdp_compte">Mot de pass</label>
                                    <input type="password" title="Please enter your password" placeholder="******" value="password123" required name="mdp_compte" id="mdp_compte" class="form-control">
                                    <span class="help-block small">Votre fort mot de passe</span>
                                </div>
                                <div class="form-group">
                                    <label><input name="remenber_me" type="checkbox" class="i i-checks"> Se souvenir de moi </label>
                                    <p class="help-block small">(Si l'ordinateur est privé)</p>
                                </div>
                                <input type="submit" name="submit" class="btn btn-success btn-block loginbtn" value="Se connecter">
                                <a href="inscription.php" class="btn btn-success btn-block loginbtn">S'inscrire</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center login-footer">
                    <p>Copyright © 2021. Tous droits réservés. Créer par RandEver</p>
                </div>
            </div>   
        </div>
        <?php include("footer-inclusion.php"); ?>
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