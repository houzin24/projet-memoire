<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>

<?php
if(isset($_GET['niveau'])){
    $niveau = $_GET['niveau'];
}
?>

<?php
if(isset($_GET['sup'])){
    $requete = $bdd->prepare('DELETE FROM seance WHERE id = ?');
    $requete->execute(array($_GET['sup']));
    header('location: modification.php?niveau='.$_GET['niveau']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Emploi du temps / Gestion Ecole</title>
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
                    <li class="active"><a href="emploi_du_temps.php">Emploi du temps</a></li>
                    <li class="active">Modification</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            
            <div class="col-md-12" style="padding:15px">
                
                <?php
                $requete = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
                $requete -> execute(array($_GET['niveau']));
                $reponse = $requete->fetch();
                ?>
                
                <label class="label label-info" style="font-size: 20px">
                    <?php echo $reponse['niveau'].' '.$reponse['filiere'].' '.$reponse['annee'] ?>
                </label><br/><br/>
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="info">Jour</th>
                            <th class="info">Heure</th>
                            <th class="info">Matière</th>
                            <th class="info">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $requete = $bdd->prepare('SELECT * FROM seance WHERE id_niveau = ?');
                        $requete -> execute(array($_GET['niveau']));
                        if(FALSE == ($reponse = $requete->fetch())){
                        ?>
                        <td colspan="10">Pas d'enregistrement</td>
                        <?php
                        } else{
                            do{
                                $requete1 = $bdd->prepare('SELECT * FROM heure WHERE id = ?');
                                $requete1 -> execute(array($reponse['id_heure']));
                                $reponse1 = $requete1->fetch();
                                
                                $requete2 = $bdd->prepare('SELECT * FROM matiere WHERE id = ?');
                                $requete2 -> execute(array($reponse['id_matiere']));
                                $reponse2 = $requete2->fetch()
                        ?>
                        <tr>
                            <td><?php echo $reponse['jour'] ?></td>
                            <td><?php echo $reponse1['heure'] ?></td>
                            <td><?php echo $reponse2['matiere'] ?></td>
                            <td class="text-center">
                                <a class="btn btn-danger btn-xs" href="?sup=<?php echo $reponse['id'] ?>&amp;niveau=<?php echo $niveau ?>">Supprimer</a>
                            </td>

                        </tr>
                        <?php
                            }while($reponse = $requete->fetch());
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.emploi').removeClass('no');
                $('.emploi').addClass('select');
            });
        </script>
    </body>
</html>