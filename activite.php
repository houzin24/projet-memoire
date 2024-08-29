<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM activite WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    
    $requete1 = $bdd->prepare('DELETE FROM participant WHERE id_activite = ?');
    $requete1->execute(array($_GET['sup']));
    header('location: activite.php');
}

if(isset($_GET['sup2'])){
    $requete = $bdd->prepare('DELETE FROM participant WHERE id = ?');
    $requete->execute(array($_GET['sup2']));
    header('location: activite.php');
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Activité / Gestion Ecole</title>
        
        <?php include("head.php"); ?>
    </head>
    
    <body>
        
        <!--sidebar-->
        <?php include('sidebar.php'); ?>
        <!--Fin sidebar-->
        
        <div class="container conteneur">
            <?php include('en_tete.php'); ?>
            
            <nav class="navbar navbar-default">
                <ul class="breadcrumb">
                    <li class="active">Activité</li>
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_activite">Ajouter activité</a></li>
                    <?php
                    }
                    ?>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Participant</th>
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <th style="width: 300px">Action</th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $req=$bdd->query('SELECT * FROM activite ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                    ?>
                    <tr>
                        <td><?php echo $reponse['nom']; ?></td>
                        <td>
                            <?php
                            $requete = $bdd->prepare('SELECT * FROM participant WHERE id_activite = ?');
                            $requete->execute(array($reponse['id']));
                            
                            while($donnees1 = $requete->fetch()){
                                $requete2 = $bdd->prepare('SELECT nom, prenom FROM etudiants WHERE id = ?');
                                $requete2->execute(array($donnees1['id_etudiant']));
                                $donnees2 = $requete2->fetch();
                            ?>
                            <p>
                                <?php
                                if($_SESSION['GEtype'] == 'Admin'){
                                ?>
                                <a class="btn btn-danger btn-xs" href="?sup2=<?php echo $donnees1['id'] ?>" style="margin-right: 10px">
                                    <i class="fa fa-times"></i>
                                </a>
                                <?php
                                }
                                ?>
                                
                                <?php echo $donnees2['nom'].' '.$donnees2['prenom']; ?>
                            </p>
                            <?php
                            }
                            ?>
                        </td>
                        <?php
                        if($_SESSION['GEtype'] == 'Admin'){
                        ?>
                        <td>
                            <a class="btn btn-success btn-xs" href="ajout_participant?id=<?php echo $reponse['id'] ?>">Ajouter participant</a>
                            <a class="btn btn-danger btn-xs" href="?sup=<?php echo $reponse['id'] ?>">Supprimer</a>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                        }while($reponse = $req->fetch());
                    }
                    ?>
                        
                    </tbody>
                </table>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.activite').removeClass('no');
                $('.activite').addClass('select');
            });
        </script>
    </body>
</html>