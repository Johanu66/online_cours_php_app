<?php
    include("../control-if-user-is-connected.php");
?>
<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Cours | O-Class</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("../../others/header-inclusion.php"); ?>
    </head>
    <body>
        <?php
            if(isset($_COOKIE['success'])){
                ?>
                <script>swal("Effectué", "<?php echo $_COOKIE['success']; ?>", "success")</script>
                <?php
                setcookie("success","",-1,"/");
            }
            include("../parts/sidebar.php");
        ?>
        <div class="all-content-wrapper">
            <?php include("../parts/header.php"); ?>
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
                                            <li><span class="bread-blod">Cours</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table Start -->
            <div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="sparkline13-list">
                                <div class="sparkline13-hd">
                                    <div class="main-sparkline13-hd" style="display: flex; justify-content: space-between;margin-bottom: 40px;">
                                        <h1>Tous les cours</h1>
                                        <?php
                                            if($_SESSION['id_type_compte'] <= 4){
                                                ?>
                                                <a href="cours-add.php"><button class="btn btn-primary mr-2">Ajouter un nouveau cours</button></a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="sparkline13-graph">
                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                        <table id="table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Intitulé</th>
                                                    <th>Classe</th>
                                                    <th>Matière</th>
                                                    <th>Début</th>
                                                    <th>Fin</th>
                                                    <th>Professeur</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table End -->
            <?php include("../parts/footer.php"); ?>
        </div>
        <?php include("../../others/footer-inclusion.php"); ?>


        <div id="modal_view" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="form_view">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title_view"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div id="details"></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <script>
            /* Affichage de la liste */ //changer
            console.log($('#table'));
            var coursDataTable = $('#table').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"cours-fetch.php", //changer
                    type:"POST"
                },
                "columnDefs":[
                    {
                        "targets":[], // changer l'index des colonnes qui ne seront pas triées
                        "orderable":false,
                    },
                ],
                "bSort" : false,
                "pageLength": 10
            });


            /* Consulter */
            $(document).on('click', '.view', function(){
                var id_view = $(this).attr("id");
                var btn_action = "consulter"
                $.ajax({
                    url:"cours-action.php",
                    method:"POST",
                    data:{id_view:id_view,btn_action:btn_action},
                    dataType:"json",
                    success:function(data)
                    {
                        $('#modal_view').modal('show');
                        $('.modal-title_view').text("Détails sur le cours");
                        $('#details').html(data);

                    }
                })
            });

            /* Téléchargement de tous les fichiers */
            $(document).on('click', '.telechargement', function(){
                var id = $(this).attr("id");
                var btn_action = "telecharger"
                $.ajax({
                    url:"cours-action.php",
                    method:"POST",
                    data:{id:id,btn_action:btn_action},
                    dataType:"json",
                    success:function(data)
                    {
                        data.forEach(element => {
                            var link = document.createElement('a');
                            link.setAttribute('href',"../../img/fichiers/"+element);
                            link.setAttribute('download', element);
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        });
                    }
                })
            });

            $(document).on('click', '.activation', function(){
                var id = $(this).attr("id");
                var btn_action = "activation"
                $.ajax({
                    url:"cours-action.php",
                    method:"POST",
                    data:{id:id,btn_action:btn_action},
                    dataType:"json",
                    success:function(data)
                    {
                        swal("Effectué", data, "success");
                        coursDataTable.ajax.reload();
                    }
                })
            });

            $(document).on('click', '.desactivation', function(){
                var id = $(this).attr("id");
                var btn_action = "desactivation";
                $.ajax({
                    url:"cours-action.php",
                    method:"POST",
                    data:{id:id,btn_action:btn_action},
                    dataType:"json",
                    success:function(data)
                    {
                        swal("Effectué", data, "success");
                        coursDataTable.ajax.reload();
                    }
                })
            });

            $(document).on('click', '.delete', function(){
                var id = $(this).attr('id');
                swal({
                    title: 'Suppression d\'cours',
                    text: 'Etes-vous sûre de vouloir supprimer ce cours ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).attr("id");
                        var btn_action = "delete";
                        $.ajax({
                            url:"cours-action.php",
                            method:"POST",
                            data:{id:id,btn_action:btn_action},
                            dataType:"json",
                            success:function(data)
                            {
                                if(data){
                                    swal("Effectué", data, "success");
                                }
                                else{
                                    swal('Échoué','La suppression a échouée.', 'error');
                                }
                                coursDataTable.ajax.reload();
                            }
                        })
                    }
                });

            });
        </script>
    </body>
</html>