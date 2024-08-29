<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Accueil / Gestion Ecole</title>
        
        <?php include("head.php"); ?>
        <style>
            .block .alert{
                height: 125px;
                background-color: #ccc;
                display: flex;
                flex-direction: column;
                justify-content: center;
                color: white;
            }
            
            .block .alert .nb{
                font-size: 28px
            }
            
            .block .alert .titre{
                font-size: 18px;
            }
            
            .block .alert i{
                position: absolute;
                right: 20px;
                bottom: 25px;
                font-size: 80px;
                color: #0009;
                opacity: 0.1;
            }
        </style>
    </head>
    
    <body>
        
        <!--sidebar-->
        <?php include('sidebar.php'); ?>
        <!--Fin sidebar-->
        
        <div class="container conteneur">
            <?php include('en_tete.php'); ?>
            
            <nav class="navbar navbar-default">
                <ul class="breadcrumb">
                    <li class="active">Page d'accueil</li>
                </ul>
                
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #d73925e6">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM etudiants');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Etudiants</p>
                    <small>Total des étudiants</small>
                    <i class="fa fa-users"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #00c0ef">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM niveau');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Niveaux</p>
                    <small>Total des niveaux</small>
                    <i class="fa fa-sitemap"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #449d44">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM activite');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Activités</p>
                    <small>Total des activités</small>
                    <i class="fa fa-dribbble"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #449d44">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM professeur');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Pofesseurs</p>
                    <small>Total des professeurs</small>
                    <i class="fa fa-male"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #e08e0b">
                    <p class="nb">6</p>
                    <p class="titre">Classes</p>
                    <small>Total des classes</small>
                    <i class="fa fa-sitemap"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #605ca8">
                    <p class="nb">7</p>
                    <p class="titre">Disciplines</p>
                    <small>Total des disciplines</small>
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #00c0ef">
                    <p class="nb">5</p>
                    <p class="titre">Parents</p>
                    <small>Total des parents</small>
                    <i class="fa fa-user"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #d81b60cc">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM matiere');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Matières</p>
                    <small>Total des matières</small>
                    <i class="fa fa-file-text-o"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #367fa9">
                    <p class="nb">6</p>
                    <p class="titre">Chauffeurs</p>
                    <small>Total des chauffeurs</small>
                    <i class="fa fa-user"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #367fa9">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM salle');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Salles</p>
                    <small>Total des salles</small>
                    <i class="fa fa-home"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #605ca8">
                    
                    <?php
                    $requete = $bdd->query('SELECT COUNT(id) AS total FROM personnel');
                    $donnees = $requete->fetch();
                    ?>
                    
                    <p class="nb"><?php echo $donnees['total']; ?></p>
                    <p class="titre">Personnels</p>
                    <small>Total des Personnels</small>
                    <i class="fa fa-folder-open"></i>
                </div>
            </div>
            
            <div class="col-md-4 block">
                <div class="alert" style="background-color: #d73925e6">
                    <p class="nb">0</p>
                    <p class="titre">Accompagnateur</p>
                    <small>Total des ccompagnateurs</small>
                    <i class="fa fa-user"></i>
                </div>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.accueil').removeClass('no');
                $('.accueil').addClass('select');
            });
        </script>
    </body>
</html>