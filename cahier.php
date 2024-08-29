<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM cahier_test WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: cahier.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Cahier de test / Gestion Ecole</title>
        <?php include("head.php"); ?>
    </head>
    
    <body ng-app="MonApp">
        
        <!--sidebar-->
        <?php include('sidebar.php'); ?>
        <!--Fin sidebar-->
        
        <div class="container conteneur">
            <?php include('en_tete.php'); ?>
            
            <nav class="navbar navbar-default">
                <ul class="breadcrumb">
                    <li class="active">Cahier de test</li>
                    <?php
                    if($_SESSION['GEtype'] != 'Admin'){
                    ?>
                    <li><a href="ajout_cahier">Ajouter dans cahier de test</a></li>
                    <?php
                    }
                    ?>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer par matiere
                            </div>
                            <select class="form-control" ng-model="matiere">
                                <option value="">Par défaut</option>
                                <?php
                                $requete = $bdd->query('SELECT * FROM matiere');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option><?php echo $donnees['matiere']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer par niveau
                            </div>
                            <select class="form-control" ng-model="niveau">
                                <option value="">Par défaut</option>
                                <?php
                                $requete = $bdd->query('SELECT * FROM niveau');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <?php
                if($_SESSION['GEtype'] == 'Admin'){
                ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer par prof
                            </div>
                            <select class="form-control" ng-model="prof">
                                <option value="">Par défaut</option>
                                <?php
                                $requete = $bdd->query('SELECT * FROM professeur');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option><?php echo $donnees['nom'].' '.$donnees['prenom']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer / Annee scolaire
                            </div>
                            <select class="form-control" ng-model="annee">
                                <option value="">Par défaut</option>
                                <?php
                                $requete = $bdd->query('SELECT * FROM annees');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option><?php echo $donnees['debut'].' - '.$donnees['fin'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="info">
                        <th>Matière</th>
                        <th>Niveau</th>
                        
                        <?php
                        if($_SESSION['GEtype'] == 'Admin'){
                        ?>
                        <th>Professeur</th>
                        <?php
                        }
                        ?>
                        
                        <th>Description</th>
                        <th>Année scolaire</th>
                        <th>Date</th>

                        <?php
                        if($_SESSION['GEtype'] != 'Admin'){
                        ?>
                        <th>Action</th>
                        <?php
                        }
                        ?>

                    </tr>
                </thead>
                <tbody ng-controller="tableCtrl">

                    <tr ng-if="info=='oui'">
                        <td colspan="15">Pas d'enregistrement</td>
                    </tr>

                    <tr ng-repeat="row in donnees | filter: {matiere:matiere , niveau:niveau , prof:prof , annee:annee}">
                        <td> {{row.matiere}} </td>
                        <td> {{row.niveau}} </td>
                        
                        <?php
                        if($_SESSION['GEtype'] == 'Admin'){
                        ?>
                        <td> {{row.prof}} </td>
                        <?php
                        }
                        ?>
                        
                        <td> {{row.description}} </td>
                        <td> {{row.annee}} </td>
                        <td> {{row.date | date: 'dd MMM yyyy'}} </td>

                        <?php
                        if($_SESSION['GEtype'] != 'Admin'){
                        ?>
                        <td class="text-center">
                            <a class="btn btn-danger btn-xs" href="?sup={{row.id}}">Supprimer</a>
                        </td>
                        <?php
                        }
                        ?>

                    </tr>
                </tbody>
            </table>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.cahier').removeClass('no');
                $('.cahier').addClass('select');
            });
            
            
            
            var app = angular.module('MonApp', []);
            app.controller('tableCtrl', function($scope, $http){
                
                $http.get("angular2.php").then(function (reponse){ //2
                    $scope.donnees = reponse.data;
                    
                    if($scope.donnees.length==0){
                        $scope.info = "oui";
                    }
                });
                
            });
        </script>
    </body>
</html>