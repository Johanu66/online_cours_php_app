<?php
    include("../control-if-user-is-connected.php");
    if(isset($_POST['submit'])){
        if(!empty($_POST['nom'])){
            $nom = htmlspecialchars($_POST['nom']);
            $desc = htmlspecialchars($_POST['desc']);
            $now = new DateTime();

            //Vérifier si la classe existait
            $statement = $bdd->query("SELECT nom_classe FROM classe");
            $find = false;
            while($row = $statement->fetch()){
                if($row["nom_classe"] == $nom){
                    $find = true;
                    break;
                }
            }
            if($find){
                $alert_text = "Cette classe existe déjà.";
            }else{
                insert("classe",[
                    "nom_classe" => $nom,
                    "desc_classe" => $desc,
                    "date_create_classe" => $now->format('Y-m-d H:i:s'),
                    "user_create_classe" => $_SESSION['nom']." ".$_SESSION['prenom'],
                    "date_last_modif_classe" => $now->format('Y-m-d H:i:s'),
                    "user_last_modif_classe" => $_SESSION['nom']." ".$_SESSION['prenom']
                ]);
                
                setcookie("success","La classe ".$nom." a été enregistré.",time()+(86400*30),"/");
                header("Location:classes.php");
            }
        }
        else{
            $alert_text = "Veuillez renseigner tous les chmaps.";
        }
    }
?>
<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Classes | Kiaalap</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("../../others/header-inclusion.php"); ?>
        <style>
            .active{
                font-size: 1.5rem;
                font-weight: bold;
                margin-left: 20px;
                color: #03a9f4;
            }
        </style>
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
                                            <li><span class="bread-blod">Classes</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Start -->
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-payment-inner-st">
                                <ul id="myTabedu1" class="tab-review-design">
                                    <li class="active">Ajout de classe</li>
                                </ul>
                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div id="reviews">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <form method="post" action class="devit-card-custom container-fluid">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="nom">Nom</label>
                                                                            <input type="text" name="nom" class="form-control" id="nom" value="<?php if(isset($_POST['nom'])){ echo($_POST['nom']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="desc">Description</label>
                                                                            <input type="text" name="desc" class="form-control" id="desc" value="<?php if(isset($_POST['desc'])){ echo($_POST['desc']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Ajouter">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->
            <?php include("../parts/footer.php"); ?>
        </div>
        <?php include("../../others/footer-inclusion.php"); ?>
    </body>
</html>