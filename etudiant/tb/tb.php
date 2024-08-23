<?php
    include("../control-if-user-is-connected.php");
?>
<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Tableau de bord | O-Class</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("../../others/header-inclusion.php"); ?>
    </head>
    <body>
        <!-- Start Left menu area -->
        <?php include("../parts/sidebar.php"); ?>
        <div class="all-content-wrapper">
            <?php include("../parts/header.php") ?>
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="breadcome-heading">
                                            <form role="search" class="sr-input-func">
                                                <input type="text" placeholder="Search..." class="search-int form-control">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Tableau de bord</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="analytics-sparkle-area">
                <div class="container-fluid">
                    <div class="row" style="margin-top: 20px;margin-bottom: 20px;">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5>COURS</h5>
                                    <h2><span class="counter"><?php echo get_total(" cours ", " del_cours='0' ") ?></span> <span class="tuition-fees">Cours</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5><P>PROFESSEURS</P></h5>
                                    <h2><span class="counter"><?php echo get_total(" professeur INNEER JOIN personne ON id_personne_fk_professeur=id_personne "," del_personne='0' ") ?></span> <span class="tuition-fees">Professeurs</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5>ETUDIANTS EN ENTENTES</h5>
                                    <h2><span class="counter"><?php echo get_total(" etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne "," del_personne='0' AND statut_personne='En attente' ") ?></span> <span class="tuition-fees">étudiants en attentes</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5>ETUDIANTS</h5>
                                    <h2><span class="counter"><?php echo get_total(" etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne "," del_personne='0' AND statut_personne!='En attente' ") ?></span> <span class="tuition-fees">étudiants</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;margin-bottom: 20px;">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5>CLASSES</h5>
                                    <h2><span class="counter"><?php echo get_total(" classe "," del_classe='0' ") ?></span> <span class="tuition-fees">classes</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5>MATIERES</h5>
                                    <h2><span class="counter"><?php echo get_total(" matiere ", " del_matiere ") ?></span> <span class="tuition-fees">matières</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="analytics-sparkle-line reso-mg-b-30">
                                <div class="analytics-content">
                                    <h5>ETUDIANTS SIGNALÉS</h5>
                                    <h2><span class="counter"><?php echo get_total(" signale ", " del_signale='0' ") ?></span> <span class="tuition-fees">étudiants signalés</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("../parts/footer.php"); ?>
        </div>
        <?php include("../../others/footer-inclusion.php"); ?>
    </body>
</html>